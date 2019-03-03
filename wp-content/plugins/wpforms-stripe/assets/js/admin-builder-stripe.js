;(function($) {

	var WPFormsStripe = {

		/**
		 * Start the engine.
		 *
		 * @since 1.0.0
		 */
		init: function() {

			WPFormsStripe.bindUIActions();

			$(document).ready(WPFormsStripe.ready);
		},

		/**
		 * Document ready.
		 *
		 * @since 1.0.0
		 */
		ready: function() {

			WPFormsStripe.creditcardFieldCheck();
		},

		/**
		 * Element bindings.
		 *
		 * @since 1.0.0
		 */
		bindUIActions: function() {

			// Check for CC field
			$(document).on('wpformsFieldUpdate', WPFormsStripe.creditcardFieldCheck);
		},

		/**
		 * Check to see if we have a CC field in the form. If we do not then
		 * alert the user via a message in the Stripe provider panel.
		 *
		 * @since 1.0.0
		 */
		creditcardFieldCheck: function(e, fields) {

			var hasCreditCard = false;

			// Previously checked fields or used getFields, but that is less
			// performant than simply checking the DOM.
			if ( $('.wpforms-field-option-credit-card').length ) {
				hasCreditCard = true;
			}

			var $message = $('.stripe-missing-cc'),
				$content = $('#stripe-provider');

			if ( ! hasCreditCard ) {
				$message.show();
				$content.find('.wpforms-panel-field').hide();
				$content.find('#wpforms-panel-field-stripe-enable').prop('checked', false);
			} else {
				$message.hide();
				$content.find('.wpforms-panel-field').show();
			}
		}
	}

	WPFormsStripe.init();
})(jQuery);
