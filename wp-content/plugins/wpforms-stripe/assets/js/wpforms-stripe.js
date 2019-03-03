;(function($) {

	var WPFormsStripe = {

		/**
		 * Start the engine.
		 *
		 * @since 1.0.0
		 */
		init: function() {

			$(document).on('wpformsReady', WPFormsStripe.forms);
		},

		/**
		 * Update submitHandler for forms containing Stripe.
		 *
		 * @since 1.0.5
		 */
		forms: function() {

			$('.wpforms-stripe form').each(function(index, el) {

				var formSettings      = $(this).validate().settings,
					formSubmitHandler = formSettings.submitHandler;

				// Replace the default submit handler
				formSettings.submitHandler = function(form) {

					var $form = $(form);

					$ccName    = $form.find('.wpforms-field-credit-card-cardname'),
					$ccCVC     = $form.find('.wpforms-field-credit-card-cardcvc'),
					$ccNumber  = $form.find('.wpforms-field-credit-card-cardnumber'),
					$ccMonth   = $form.find('.wpforms-field-credit-card-cardmonth'),
					$ccYear    = $form.find('.wpforms-field-credit-card-cardyear');

					var valid = $form.validate().form();

					// Only charge if there is a CC number provided
					if (valid && $ccNumber.val().length > 0) {

						$form.find('.wpforms-submit').prop('disabled', true);

						// Form is valid and there is a CC to process
						Stripe.setPublishableKey(wpforms_stripe.publishable_key);
						Stripe.card.createToken({
							number:    $ccNumber.val(),
							name:      $ccName.val(),
							cvc:       $ccCVC.val(),
							exp_month: $ccMonth.val(),
							exp_year:  $ccYear.val(),
						}, function(status, response) {

							if (response.error) {

								$form.find('.wpforms-submit').prop('disabled', false);
								$form.find('.wpforms-submit-container').before('<div class="wpforms-error-alert">'+response.error.message+'</div>');
								$form.validate().cancelSubmit = true;

							} else {

								var token       = response['id'],
									$tokenInput = $('<input type="hidden" name="wpforms[stripeToken]" value="'+token+'">');

								$form.append($tokenInput);
								return formSubmitHandler(form);
							}
						});

					} else if ( valid ) {

						// Form is valid, however no CC to process.
						$form.find('.wpforms-submit').prop('disabled', false);
						return formSubmitHandler(form);

					} else {

						// Form is not valid
						$form.find('.wpforms-submit').prop('disabled', false);
						$form.validate().cancelSubmit = true;
					}
				}

			});
		}
	}

	WPFormsStripe.init();
})(jQuery);
