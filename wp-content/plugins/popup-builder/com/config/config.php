<?php
class SgpbPopupConfig
{
	public static function addDefine($name, $value)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}

	public static function init()
	{
		self::addDefine('SGPB_POPUP_FREE_MIN_VERSION', '3.0.2');
		self::addDefine('SGPB_POPUP_PRO_MIN_VERSION', '4.0');

		self::addDefine('SGPB_POPUP_PKG_FREE', 1);
		self::addDefine('SGPB_POPUP_PKG_SILVER', 2);
		self::addDefine('SGPB_POPUP_PKG_GOLD', 3);
		self::addDefine('SGPB_POPUP_PKG_PLATINUM', 4);
		self::addDefine('SG_POPUP_PRO_URL', 'https://popup-builder.com/#prices');
		self::addDefine('SG_POPUP_TICKET_URL', 'https://sygnoos.ladesk.com/submit_ticket');
		self::addDefine('SG_POPUP_RATE_US_URL', 'https://wordpress.org/support/plugin/popup-builder/reviews/?filter=5');
		self::addDefine('SG_POPUP_AD_BLOCK_URL', 'https://popup-builder.com/downloads/adblock/');
		self::addDefine('SG_POPUP_ANALYTICS_URL', 'https://popup-builder.com/downloads/analytics/');
		self::addDefine('SG_POPUP_EXIT_INTENT_URL', 'https://popup-builder.com/downloads/exit-intent/');
		self::addDefine('SG_POPUP_MAILCHIMP_URL', 'https://popup-builder.com/downloads/mailchimp/');
		self::addDefine('SG_POPUP_AWEBER_URL', 'https://popup-builder.com/downloads/aweber/');
		self::addDefine('SG_POPUP_ADMIN_URL', admin_url());
		self::addDefine('SG_POPUP_BUILDER_URL', plugins_url().'/'.SG_POPUP_FOLDER_NAME.'/');
		self::addDefine('SG_POPUP_BUILDER_PATH', WP_PLUGIN_DIR.'/'.SG_POPUP_FOLDER_NAME.'/');
		self::addDefine('SG_POPUP_COM_PATH', SG_POPUP_BUILDER_PATH.'com/');
		self::addDefine('SG_POPUP_CONFIG_PATH', SG_POPUP_COM_PATH.'config/');
		self::addDefine('SG_POPUP_PUBLIC_PATH', SG_POPUP_BUILDER_PATH.'public/');
		self::addDefine('SG_POPUP_CLASSES_PATH', SG_POPUP_COM_PATH.'classes/');
		self::addDefine('SG_POPUP_DATA_TABLES_PATH', SG_POPUP_CLASSES_PATH.'dataTable/');
		self::addDefine('SG_POPUP_CLASSES_POPUPS_PATH', SG_POPUP_CLASSES_PATH.'popups/');
		self::addDefine('SG_POPUP_EXTENSION_PATH', SG_POPUP_CLASSES_PATH.'extension/');
		self::addDefine('SG_POPUP_LIBS_PATH', SG_POPUP_COM_PATH.'libs/');
		self::addDefine('SG_POPUP_HELPERS_PATH', SG_POPUP_COM_PATH.'helpers/');
		self::addDefine('SG_POPUP_JS_PATH', SG_POPUP_PUBLIC_PATH.'js/');
		self::addDefine('SG_POPUP_CSS_PATH', SG_POPUP_PUBLIC_PATH.'css/');
		self::addDefine('SG_POPUP_VIEWS_PATH', SG_POPUP_PUBLIC_PATH.'views/');
		self::addDefine('SG_POPUP_TYPE_OPTIONS_PATH', SG_POPUP_VIEWS_PATH.'options/');
		self::addDefine('SG_POPUP_TYPE_MAIN_PATH', SG_POPUP_VIEWS_PATH.'main/');
		self::addDefine('SG_POPUP_PUBLIC_URL', SG_POPUP_BUILDER_URL.'public/');
		self::addDefine('SG_POPUP_JS_URL', SG_POPUP_PUBLIC_URL.'js/');
		self::addDefine('SG_POPUP_CSS_URL', SG_POPUP_PUBLIC_URL.'css/');
		self::addDefine('SG_POPUP_IMG_URL', SG_POPUP_PUBLIC_URL.'img/');
		self::addDefine('SG_POPUP_SOUND_URL', SG_POPUP_PUBLIC_URL.'sound/');
		self::addDefine('SG_POPUP_DEFAULT_TIME_ZONE', 'UTC');
		self::addDefine('SG_POPUP_CATEGORY_TAXONOMY', 'popup-categories');
		self::addDefine('SG_RANDOM_TAXONOMY_SLUG', 'randompopupslug');
		self::addDefine('SG_POPUP_MINIMUM_PHP_VERSION', '5.3.3');
		self::addDefine('SG_POPUP_POST_TYPE', 'popupbuilder');
		self::addDefine('SG_POPUP_NEWSLETTER_PAGE', 'newsletter');
		self::addDefine('SG_POPUP_SETTINGS_PAGE', 'settings');
		self::addDefine('SGPB_POPUP_LICENSE', 'license');
		self::addDefine('SGPB_FILTER_REPEAT_INTERVAL', 50);
		self::addDefine('SG_POPUP_TEXT_DOMAIN', 'popupBuilder');
		self::addDefine('SG_POPUP_STORE_URL', 'https://popup-builder.com/');
		self::addDefine('SG_POPUP_AUTHOR', 'Sygnoos');
		self::addDefine('SG_POPUP_KEY', 'POPUP_BUILDER');
		self::addDefine('SG_AJAX_NONCE', 'popupBuilderAjaxNonce');
		self::addDefine('SG_CONDITION_FIRST_RULE', 0);
		self::addDefine('SGPB_AJAX_STATUS_FALSE', 0);
		self::addDefine('SGPB_AJAX_STATUS_TRUE', 1);
		self::addDefine('SG_COUNTDOWN_COUNTER_SECONDS_SHOW', 1);
		self::addDefine('SG_COUNTDOWN_COUNTER_SECONDS_HIDE', 2);
		self::addDefine('SGPB_SUBSCRIBERS_TABLE_NAME', 'sgpb_subscribers');
		self::addDefine('SGPB_POSTS_TABLE_NAME', 'posts');
		self::addDefine('SGPB_APP_POPUP_TABLE_LIMIT', 15);
		self::addDefine('SGPB_SUBSCRIBERS_ERROR_TABLE_NAME', 'sgpb_subscription_error_log');
		self::addDefine('SGPB_CRON_REPEAT_INTERVAL', 1);
		self::addDefine('SGPB_FACEBOOK_APP_ID', 1725074220856984);
		self::addDefine('SGPB_POPUP_TYPE_AGE_RESTRICTION', 'ageRestriction');
		self::addDefine('SGPB_POPUP_DEFAULT_SOUND', 'popupOpenSound.wav');
		self::addDefine('SGPB_POPUP_EXTENSIONS_PATH', SG_POPUP_COM_PATH.'extensions/');
		self::addDefine('SGPB_DONT_SHOW_POPUP_EXPIRY', 365);
		self::addDefine('SGPB_CONTACT_FORM_7_BEHAVIOR_KEY', 'contact-form-7');
		self::popupTypesInit();
	}

	public static function popupTypesInit()
	{
		global $SGPB_POPUP_TYPES;

		$SGPB_POPUP_TYPES['typeName'] = apply_filters('sgpbAddPopupType', array(
			'image' => SGPB_POPUP_PKG_FREE,
			'html' => SGPB_POPUP_PKG_FREE,
			'fblike' => SGPB_POPUP_PKG_FREE,
			'subscription' => SGPB_POPUP_PKG_FREE,
			'iframe' => SGPB_POPUP_PKG_SILVER,
			'video' => SGPB_POPUP_PKG_SILVER,
			SGPB_POPUP_TYPE_AGE_RESTRICTION => SGPB_POPUP_PKG_GOLD,
			'countdown' => SGPB_POPUP_PKG_GOLD,
			'social' => SGPB_POPUP_PKG_GOLD,
			'contactForm' => SGPB_POPUP_PKG_GOLD
		));

		$SGPB_POPUP_TYPES['typePath'] = apply_filters('sgpbAddPopupTypePath', array(
			'image' => SG_POPUP_CLASSES_POPUPS_PATH,
			'html' => SG_POPUP_CLASSES_POPUPS_PATH,
			'fblike' => SG_POPUP_CLASSES_POPUPS_PATH,
			'iframe' => SG_POPUP_CLASSES_POPUPS_PATH,
			'video' => SG_POPUP_CLASSES_POPUPS_PATH,
			'ageRestriction' => SG_POPUP_CLASSES_POPUPS_PATH,
			'countdown' => SG_POPUP_CLASSES_POPUPS_PATH,
			'social' => SG_POPUP_CLASSES_POPUPS_PATH,
			'subscription' => SG_POPUP_CLASSES_POPUPS_PATH,
			'contactForm' => SG_POPUP_CLASSES_POPUPS_PATH
		));

		$SGPB_POPUP_TYPES['typeLabels'] = apply_filters('sgpbAddPopupTypeLabels', array(
			'image' => __('Image', SG_POPUP_TEXT_DOMAIN),
			'html' => __('HTML', SG_POPUP_TEXT_DOMAIN),
			'fblike' => __('Facebook', SG_POPUP_TEXT_DOMAIN),
			'iframe' => __('Iframe', SG_POPUP_TEXT_DOMAIN),
			'video' => __('Video', SG_POPUP_TEXT_DOMAIN),
			'ageRestriction' => __('Restriction', SG_POPUP_TEXT_DOMAIN),
			'countdown' => __('Countdown', SG_POPUP_TEXT_DOMAIN),
			'social' => __('Social', SG_POPUP_TEXT_DOMAIN),
			'subscription' => __('Subscription', SG_POPUP_TEXT_DOMAIN),
			'contactForm' => __('Contact form', SG_POPUP_TEXT_DOMAIN)
		));
	}
}

SgpbPopupConfig::init();
