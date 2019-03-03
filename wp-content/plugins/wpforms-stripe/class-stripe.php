<?php
/**
 * Stripe integration.
 *
 * @since 1.0.0
 * @package WPFormsStripe
 */
class WPForms_Stripe extends WPForms_Payment {

	/**
	 * One is the loneliest number that you'll ever do.
	 *
	 * @since 1.0.8
	 * @var object
	 */
	private static $instance;

	/**
	 * Entry meta data for successful payments.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $entry_data = false;

	/**
	 * Stripe Charge details.
	 *
	 * @since 1.0.6
	 * @var object
	 */
	public $charge = false;

	/**
	 * Main WPForms_Stripe Instance.
	 *
	 * Ensures that only one instance of WPForms_Stripe exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.8
	 * @return WPForms_Stripe
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPForms_Stripe ) ) {
			self::$instance = new WPForms_Stripe;
		}

		return self::$instance;
	}

	/**
	 * Initialize.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		$this->version  = WPFORMS_STRIPE_VERSION;
		$this->name     = 'Stripe';
		$this->slug     = 'stripe';
		$this->priority = 10;
		$this->icon     = plugins_url( 'assets/images/addon-icon-stripe.png', __FILE__ );

		add_action( 'wpforms_process',                  array( $this, 'process_entry'        ), 10, 4 );
		add_action( 'wpforms_process_complete',         array( $this, 'process_entry_meta'   ), 10, 4 );
		add_action( 'wpforms_wp_footer',                array( $this, 'frontend_enqueues'    )        );
		add_action( 'wpforms_builder_enqueues',         array( $this, 'admin_enqueues'       )        );
		add_action( 'wpforms_frontend_container_class', array( $this, 'form_container_class' ), 10, 2 );
		add_filter( 'wpforms_settings_defaults',        array( $this, 'register_settings'    )        );
	}

	/**
	 * Register Settings fields.
	 *
	 * @since 1.1.0
	 * @param array $settings
	 * @return array
	 */
	public function register_settings( $settings ) {

		$desc = sprintf( __( 'Keys can be found in your Stripe account dashboard. For more information see our <a href="%s" target="_blank" rel="noopener noreferrer">Stripe documentation</a>.', 'wpforms' ), 'https://wpforms.com/docs/how-to-install-and-use-the-stripe-addon-with-wpforms/' );

		$settings['payments']['stripe-heading'] = array(
			'id'       => 'strie-heading',
			'content'  => '<h4>' . __( 'Stripe', 'wpforms_settings' ) . '</h4><p>' . $desc . '</p>',
			'type'     => 'content',
			'no_label' => true,
			'class'    => array( 'section-heading' ),
		);
		$settings['payments']['stripe-test-secret-key'] = array(
			'id'        => 'stripe-test-secret-key',
			'name'      => __( 'Test Secret Key', 'wpforms' ),
			'type'      => 'text',
		);
		$settings['payments']['stripe-test-publishable-key'] = array(
			'id'        => 'stripe-test-publishable-key',
			'name'      => __( 'Test Publishable Key', 'wpforms_stripe' ),
			'type'      => 'text',
		);
		$settings['payments']['stripe-live-secret-key'] = array(
			'id'        => 'stripe-live-secret-key',
			'name'      => __( 'Live Secret Key', 'wpforms_stripe' ),
			'type'      => 'text',
		);
		$settings['payments']['stripe-live-publishable-key'] = array(
			'id'        => 'stripe-live-publishable-key',
			'name'      => __( 'Live Publishable Key', 'wpforms_stripe' ),
			'type'      => 'text',
		);
		$settings['payments']['stripe-test-mode'] = array(
			'id'        => 'stripe-test-mode',
			'name'      => __( 'Test Mode', 'wpforms_stripe' ),
			'desc'      => __( 'In test mode and no live Stripe transactions are processed.', 'wpforms_stripe' ),
			'type'      => 'checkbox',
		);

		return $settings;
	}

	/**
	 * Check for configured Stripe keys.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public function has_stripe_keys() {

		$test_secret_key      = wpforms_setting( 'stripe-test-secret-key', false );
		$test_publishable_key = wpforms_setting( 'stripe-test-publishable-key', false );
		$live_secret_key      = wpforms_setting( 'stripe-live-secret-key', false );
		$live_publishable_key = wpforms_setting( 'stripe-live-publishable-key', false );

		// Before continuing we verify that Stripe API has indeed been setup
		if ( ! $test_secret_key || ! $test_publishable_key || ! $live_secret_key || ! $live_publishable_key ) {
			return false;
		}
		return true;
	}

	/**
	 * Process and submit entry to provider.
	 *
	 * @since 1.0.0
	 * @param array $fields
	 * @param array $entry
	 * @param array $form_data
	 */
	public function process_entry( $fields, $entry, $form_data ) {

		$error = false;

		// Check if payment method exists
		if ( empty( $form_data['payments'][$this->slug] ) ) {
			return;
		}

		// Check required payment settings
		$payment_settings = $form_data['payments'][$this->slug];
		if ( empty( $payment_settings['enable'] ) || $payment_settings['enable'] != '1'  ) {
			return;
		}

		// Check for conditional logic
		if (   function_exists( 'wpforms_conditional_logic' )
			&& !empty( $form_data['payments']['stripe']['conditional_logic'] )
			&& !empty( $form_data['payments']['stripe']['conditional_type'] )
			&& !empty( $form_data['payments']['stripe']['conditionals'] )
		) {
			// All conditional logic checks passed, continue with processing
			$process = wpforms_conditional_logic()->conditionals_process( $fields, $form_data, $form_data['payments']['stripe']['conditionals'] );

			if ( 'stop' == $form_data['payments']['stripe']['conditional_type'] ) {
				$process = !$process;
			}

			// If preventing the notification, log it, and then bail
			if ( ! $process ) {
				wpforms_log(
					__( 'Stripe Payment stopped by conditional logic', 'wpforms_stripe' ),
					$fields,
					array(
						'type'    => array( 'payment', 'conditional_logic' ),
						'form_id' => $form_data['id'],
					)
				);
				return;
			}
		}

		// Check for Stripe token
		if ( !isset( $entry['stripeToken'] ) || empty( $entry['stripeToken'] ) ) {
			$error = __( 'Stripe Payment stopped, missing token', 'wpforms_stripe' );
		}

		// Check for Stripe keys
		if ( ! $this->has_stripe_keys() ) {
			$error = __( 'Stripe Payment stopped, missing keys', 'wpforms_stripe' );
		}

		// Check that, despite how the form is configured, the form and
		// entry actually contain payment fields, otherwise no need to proceed
		$form_has_payments  = wpforms_has_payment( 'form', $form_data );
		$entry_has_paymemts = wpforms_has_payment( 'entry', $fields );
		if ( ! $form_has_payments || ! $entry_has_paymemts ) {
			$error = __( 'Stripe Payment stopped, missing payment fields', 'wpforms_stripe' );
		}

		// Check total charge amount
		$amount = wpforms_get_total_payment( $fields );
		if ( empty( $amount ) || $amount == wpforms_sanitize_amount( 0 ) ) {
			$error = __( 'Stripe Payment stopped, invalid/empty amount', 'wpforms_stripe' );
		}

		// Log error if we have one and stop
		if ( $error ) {
			wpforms_log(
				$error,
				'',
				array(
					'type'    => array( 'error', 'payment' ),
					'form_id' => $form_data['id'],
				)
			);
			return;
		}

		$test_mode = wpforms_setting( 'stripe-test-mode', false );
		if ( $test_mode ) {
			$secret_key = wpforms_setting( 'stripe-test-secret-key' );
		} else {
			$secret_key = wpforms_setting( 'stripe-live-secret-key' );
		}

		// Load Stripe
		if ( ! class_exists( 'Stripe\Stripe' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'vendor/init.php';
		}

		\Stripe\Stripe::setApiKey( $secret_key );

		$err = '';

		try {

			// Proceed with making the charge
			$args = array(
				'amount'      => $amount*100,
				'currency'    => strtolower( wpforms_setting( 'currency', 'USD' ) ),
				'source'      => $entry['stripeToken'],
				'metadata'    => array(
					'form_id'   => $form_data['id']
				),
			);

			// Payment description
			if ( !empty( $payment_settings['payment_description'] ) ) {
				$args['description'] = html_entity_decode( $payment_settings['payment_description'], ENT_COMPAT, 'UTF-8' );
			}

			// Receipt email
			if ( !empty( $payment_settings['receipt_email'] ) && !empty( $fields[$payment_settings['receipt_email']]['value'] ) ) {
				$args['receipt_email'] = sanitize_email( $fields[$payment_settings['receipt_email']]['value'] );
			}

			// Let's do this.
			$this->charge = \Stripe\Charge::create( $args );

			// Set some of the CC details upstream
			foreach ( $fields as $field_id => $field ) {
				if ( $field['type'] == 'credit-card' ) {
					$field_val = 'XXXXXXXXXXXX' . $this->charge->source->last4 . "\n" . $this->charge->source->brand;
					wpforms()->process->fields[$field_id]['value'] = apply_filters( 'wpforms_stripe_creditcard_value', $field_val, $this->charge );
				}
			}

			$test_mode = wpforms_setting( 'stripe-test-mode', false );
			if ( $test_mode ) {
				$mode = 'test';
			} else {
				$mode = 'production';
			}

			// Update entry to include payment details, this will be added in
			// post processing
			$this->entry_data = array(
				'status' => 'completed',
				'type'   => 'payment',
				'meta'   => json_encode( array(
					'payment_type'        => $this->slug,
					'payment_total'       => $amount,
					'payment_currency'    => wpforms_setting( 'currency', 'USD' ),
					'payment_transaction' => $this->charge->id,
					'payment_mode'        => esc_html( $mode ),
				) ),
			);

		} catch(\Stripe\Error\Card $e) {

			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		} catch (\Stripe\Error\RateLimit $e) {

			// Too many requests made to the API too quickly
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		} catch (\Stripe\Error\InvalidRequest $e) {

			// Invalid parameters were supplied to Stripe's API
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		} catch (\Stripe\Error\Authentication $e) {

			// Authentication with Stripe's API failed
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		} catch (\Stripe\Error\ApiConnection $e) {

			// Network communication with Stripe failed
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		} catch (\Stripe\Error\Base $e) {

			// Display a very generic error to the user
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		} catch (Exception $e) {

			// Something else happened, completely unrelated to Stripe
			$body = $e->getJsonBody();
			$err  = $body['error'];
			wpforms()->process->errors[$form_data['id']]['footer'] =  __( 'Credit Card Payment Error: ', 'wpforms_stripe' ) . $err['message'];

		}
		if ( !empty( $err ) ) {
			wpforms_log(
				__( 'Stripe Payment stopped by error', 'wpforms_stripe' ),
				$err['message'],
				array(
					'type'    => array( 'payment', 'error' ),
					'form_id' => $form_data['id'],
				)
			);
		}
	}

	/**
	 * Add the payment meta data to completed charges.
	 *
	 * @since 1.0.0
	 * @param array $fields
	 * @param array $fields
	 * @param array $form_data
	 * @param int $entry_id
	 */
	public function process_entry_meta( $fields, $entry, $form_data, $entry_id ) {

		if ( $this->entry_data ) {
			// Update payment details for successful charge
			wpforms()->entry->update( $entry_id, $this->entry_data );
		}

		if ( $this->charge ) {
			// Processing complete
			do_action( 'wpforms_stripe_process_complete', $fields, $form_data, $entry_id, $this->charge );
		}
	}

	/**
	 * Enqueue assets in the frontend. Maybe.
	 *
	 * @since 1.0.0
	 *
	 * @param array $forms
	 */
	public function frontend_enqueues( $forms ) {

		// Check if form(s) on page has a CC field
		if ( false == wpforms_has_field_type( 'credit-card', $forms, true ) )
			return;

		// Check if form(s) on page has a stripe configured
		$stripe = false;

		foreach( $forms as $form ) {
			if ( !empty( $form['payments']['stripe']['enable'] ) && '1' == $form['payments']['stripe']['enable'] ) {
				$stripe = true;
				break;
			}
		}

		if ( !$stripe )
			return;

		if ( ! $this->has_stripe_keys() )
			return;

		// OK, we made it this far...

		// Check if we are using test or production keys
		$test_mode = wpforms_setting( 'stripe-test-mode', false );
		if ( $test_mode ) {
			$publishable_key = wpforms_setting( 'stripe-test-publishable-key', false );
		} else {
			$publishable_key = wpforms_setting( 'stripe-live-publishable-key', false );
		}

		// Official Stripe library
		wp_enqueue_script(
			'stripe-js',
			'https://js.stripe.com/v2/',
			array( 'jquery' )
		);

		wp_enqueue_script(
			'wpforms-stripe',
			plugin_dir_url( __FILE__ ) . 'assets/js/wpforms-stripe.js',
			array( 'jquery', 'stripe-js' ),
			WPFORMS_STRIPE_VERSION
		);

		$vars = array(
			'publishable_key' => trim( $publishable_key )
		);
		wp_localize_script( 'wpforms-stripe', 'wpforms_stripe', $vars );
	}

	/**
	 * Enqueue assets for the builder.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueues() {

		wp_enqueue_script(
			'wpforms-builder-stripe',
			plugin_dir_url( __FILE__ ) . 'assets/js/admin-builder-stripe.js',
			array( 'jquery' ),
			WPFORMS_STRIPE_VERSION,
			false
		);
	}

	/**
	 * Add class to form container.
	 *
	 * @since 1.0.0
	 * @param array $class
	 * @param array $form_data
	 * @return array
	 */
	public function form_container_class( $class, $form_data ) {

		// Check if form(s) on page has a CC field
		if ( false == wpforms_has_field_type( 'credit-card', $form_data ) )
			return $class;

		if ( ! $this->has_stripe_keys() )
			return $class;

		if ( !empty( $form_data['payments']['stripe']['enable'] ) && '1' == $form_data['payments']['stripe']['enable'] ) {
			$class[] = 'wpforms-stripe';
		}
		return $class;
	}

	/**
	 * Display content inside the panel content area.
	 *
	 * @since 1.0.0
	 */
	public function builder_content() {

		$keys = $this->has_stripe_keys();
		if ( !$keys ) {
			printf(
				__( 'Before enabling Stripe payments you need to setup your Stripe API keys (both Live and Test) on the <a href="%s">Settings page</a>.', 'wpforms_stripe' ),
				admin_url( 'admin.php?page=wpforms-settings&view=payments' )
			);
			return;
		}

		echo '<p class="stripe-missing-cc" style="margin:0;">' . __( 'To use Stripe payments you need to add a Credit Card field to the form', 'wpforms_stripe' ) .'</p>';

		wpforms_panel_field(
			'checkbox',
			$this->slug,
			'enable',
			$this->form_data,
			__( 'Enable Stripe payments', 'wpforms_stripe' ),
			array(
				'parent' => 'payments',
				'default' => '0',
			)
		);
		wpforms_panel_field(
			'text',
			$this->slug,
			'payment_description',
			$this->form_data,
			__( 'Payment Description', 'wpforms_stripe' ),
			array(
				'parent' => 'payments',
				'tooltip' => __( 'Enter your payment description. Eg: Donation for the soccer team.', 'wpforms_stripe' )
			)
		);
		wpforms_panel_field(
			'select',
			$this->slug,
			'receipt_email',
			$this->form_data,
			__( 'Stripe Payment Receipt', 'wpforms_stripe' ),
			array(
				'parent'      => 'payments',
				'field_map'   => array( 'email' ),
				'placeholder' => __( '-- Select Email --', 'wpforms_stripe' ),
				'tooltip'     => __( 'If you would like to have Stripe send a receipt after payment, select the email field to use. This is optional but recommended.', 'wpforms_stripe' ),
			)
		);

		if ( function_exists( 'wpforms_conditional_logic' ) ) {
			wpforms_conditional_logic()->conditionals_block( array(
				'form'        => $this->form_data,
				'type'        => 'panel',
				'panel'       => 'stripe',
				'parent'      => 'payments',
				'actions'     => array(
					'go'    => __( 'Process', 'wpforms_stripe' ),
					'stop'  => __( 'Don\'t process', 'wpforms_stripe' ),
				),
				'action_desc' => __( 'this charge if', 'wpforms_stripe' ),
				'reference'   => __( 'Stripe payment', 'wpforms_stripe' ),
			) );
		} else {
			echo '<p class="note">' . sprintf( __( 'Install the <a href="%s">Conditional Logic add-on</a> to enable conditional logic for Stripe payments.', 'wpforms_stripe' ), admin_url( 'admin.php?page=wpforms-addons' ) ) . '</p>';
		}
	}
}

/**
 * The function which returns the one WPForms Stripe instance.
 *
 * @since 1.0.8
 * @return object
 */
function wpforms_stripe_instance() {
	return WPForms_Stripe::instance();
}
wpforms_stripe_instance();
