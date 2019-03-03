<?php
require_once(SG_POPUP_EXTENSION_PATH.'SgpbIPopupExtension.php');
use sgpb\AdminHelper;

class SgpbPopupExtension implements SgpbIPopupExtension
{
	public function getNewsletterPageKey()
	{
		return SG_POPUP_POST_TYPE.'_page_'.SG_POPUP_NEWSLETTER_PAGE;
	}

	public function getSettingsPageKey()
	{
		return SG_POPUP_POST_TYPE.'_page_'.SG_POPUP_SETTINGS_PAGE;
	}

	public function getScripts($pageName, $data)
	{
		$jsFiles = array();
		$localizeData = array();
		$translatedData = ConfigDataHelper::getJsLocalizedData();
		$newsletterPage = $this->getNewsletterPageKey();
		$settingsPage = $this->getSettingsPageKey();

		$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'ExtensionsNotification.js');
		$localizeData[] = array(
			'handle' => 'ExtensionsNotification.js',
			'name' => 'SGPB_JS_EXTENSIONS_PARAMS',
			'data' => array(
				'nonce' => wp_create_nonce(SG_AJAX_NONCE)
			)
		);

		$allowPages = array(
			'popupType',
			'editpage',
			'popupspage',
			$newsletterPage,
			$settingsPage
		);

		if ($pageName == $newsletterPage) {
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Newsletter.js');
		}

		if (in_array($pageName, $allowPages)) {
			$jsFiles[] = array('folderUrl'=> '', 'filename' => 'wp-color-picker');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'select2.min.js', 'dep' => '', 'ver' => '3.86', 'inFooter' => '');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'sgpbSelect2.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'jquery.datetimepicker.full.min.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'bootstrap.min.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'sgPopupRangeSlider.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Backend.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Popup.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'PopupConfig.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Banner.js');

			$localizeData[] = array(
				'handle' => 'Backend.js',
				'name' => 'SGPB_JS_PARAMS',
				'data' => array(
					'url'   => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce(SG_AJAX_NONCE)
				)
			);

			$localizeData[] = array(
				'handle' => 'sgpbSelect2.js',
				'name' => 'SGPB_JS_PACKAGES',
				'data' => array(
					'packages' => array(
						'current' => SGPB_POPUP_PKG,
						'free' => SGPB_POPUP_PKG_FREE,
						'silver' => SGPB_POPUP_PKG_SILVER,
						'gold' => SGPB_POPUP_PKG_GOLD,
						'platinum' => SGPB_POPUP_PKG_PLATINUM
					)
				)
			);

			$localizeData[] = array(
				'handle' => 'Banner.js',
				'name' => 'SGPB_JS_PARAMS',
				'data' => array(
					'url'   => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce(SG_AJAX_NONCE)
				)
			);

			$localizeData[] = array(
				'handle' => 'Backend.js',
				'name' => 'SGPB_JS_LOCALIZATION',
				'data' => $translatedData
			);

			$localizeData[] = array(
				'handle' => 'Popup.js',
				'name' => 'sgpbPublicUrl',
				'data' => SG_POPUP_PUBLIC_URL
			);
		}
		else if ($pageName == 'subscribers') {
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'select2.min.js', 'dep' => '', 'ver' => '3.86', 'inFooter' => '');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'sgpbSelect2.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Subscribers.js');
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Banner.js');

			$localizeData[] = array(
				'handle' => 'Subscribers.js',
				'name' => 'SGPB_JS_PARAMS',
				'data' => array(
					'url'   => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce(SG_AJAX_NONCE),
					'packages' => array(
						'current' => SGPB_POPUP_PKG,
						'silver' => SGPB_POPUP_PKG_SILVER,
						'gold' => SGPB_POPUP_PKG_GOLD,
						'platinum' => SGPB_POPUP_PKG_PLATINUM
					)
				)
			);

			$localizeData[] = array(
				'handle' => 'sgpbSelect2.js',
				'name' => 'SGPB_JS_PACKAGES',
				'data' => array(
					'packages' => array(
						'current' => SGPB_POPUP_PKG,
						'free' => SGPB_POPUP_PKG_FREE,
						'silver' => SGPB_POPUP_PKG_SILVER,
						'gold' => SGPB_POPUP_PKG_GOLD,
						'platinum' => SGPB_POPUP_PKG_PLATINUM
					)
				)
			);

			$localizeData[] = array(
				'handle' => 'Subscribers.js',
				'name' => 'SGPB_JS_ADMIN_URL',
				'data' => array(
					'url'   => SG_POPUP_ADMIN_URL.'admin-post.php',
					'nonce' => wp_create_nonce(SG_AJAX_NONCE)
				)
			);

			$localizeData[] = array(
				'handle' => 'Subscribers.js',
				'name' => 'SGPB_JS_LOCALIZATION',
				'data' => $translatedData
			);

			$localizeData[] = array(
				'handle' => 'Banner.js',
				'name' => 'SGPB_JS_PARAMS',
				'data' => array(
					'url'   => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce(SG_AJAX_NONCE)
				)
			);
		}

		$scriptData = array(
			'jsFiles' => apply_filters('sgpbAdminJsFiles', $jsFiles),
			'localizeData' => apply_filters('sgpbAdminJsLocalizedData', $localizeData)
		);

		$scriptData = apply_filters('sgpbAdminJs', $scriptData);

		return $scriptData;
	}

	public function getStyles($pageName, $data)
	{
		$cssFiles = array();
		$newsletterPage = $this->getNewsletterPageKey();
		$settingsPage = $this->getSettingsPageKey();

		$allowPages = array(
			'popupType',
			'editpage',
			'popupspage',
			$newsletterPage,
			$settingsPage
		);

		if (in_array($pageName, $allowPages)) {
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'jquery.dateTimePicker.min.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'sgbp-bootstrap.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'popupAdminStyles.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'select2.min.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'sgPopupRangeSlider.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => '', 'filename' => 'wp-color-picker');
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'animate.css');
		}
		else if ($pageName == 'subscribers') {
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'sgbp-bootstrap.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'popupAdminStyles.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
			$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'select2.min.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
		}

		$cssData = array(
			'cssFiles' => apply_filters('sgpbAdminCssFiles', $cssFiles)
		);
		return $cssData;
	}

	public function getFrontendScripts($page, $popupObjs)
	{
		$jsFiles = array();
		$localizeData = array();
		$jsFiles[] = array('folderUrl'=> '', 'filename' => 'wp-color-picker');
		$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'Popup.js');
		$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'PopupConfig.js', 'dep' => array('Popup.js'));
		$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'PopupBuilder.js', 'dep' => array('jquery'));
		if (SGPB_POPUP_PKG >= SGPB_POPUP_PKG_SILVER) {
			$jsFiles[] = array('folderUrl'=> SG_POPUP_JS_URL, 'filename' => 'PopupBuilderProFunctionality.js', 'dep' => array('jquery'));
		}

		$localizeData[] = array(
			'handle' => 'PopupBuilder.js',
			'name' => 'SGPB_POPUP_PARAMS',
			'data' => array(
				'popupTypeAgeRestriction' => SGPB_POPUP_TYPE_AGE_RESTRICTION,
				'defaultThemeImages' => array(
					1 => AdminHelper::defaultButtonImage('sgpb-theme-1'),
					2 => AdminHelper::defaultButtonImage('sgpb-theme-2'),
					3 => AdminHelper::defaultButtonImage('sgpb-theme-3'),
					5 => AdminHelper::defaultButtonImage('sgpb-theme-5'),
					6 => AdminHelper::defaultButtonImage('sgpb-theme-6')
				),
				'homePageUrl' => get_home_url().'/',
				'isPreview' => is_preview(),
				'convertedIdsReverse' => AdminHelper::getReverseConvertIds(),
				'dontShowPopupExpireTime' => SGPB_DONT_SHOW_POPUP_EXPIRY
			)
		);
		$localizeData[] = array(
			'handle' => 'PopupBuilder.js',
			'name' => 'SGPB_JS_PACKAGES',
			'data' => array(
				'packages' => array(
					'current' => SGPB_POPUP_PKG,
					'free' => SGPB_POPUP_PKG_FREE,
					'silver' => SGPB_POPUP_PKG_SILVER,
					'gold' => SGPB_POPUP_PKG_GOLD,
					'platinum' => SGPB_POPUP_PKG_PLATINUM
				)
			)
		);

		$localizeData[] = array(
			'handle' => 'Popup.js',
			'name' => 'sgpbPublicUrl',
			'data' => SG_POPUP_PUBLIC_URL
		);

		$localizeData[] = array(
			'handle' => 'Popup.js',
			'name' => 'SGPB_JS_PARAMS',
			'data' => array(
				'ajaxUrl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce(SG_AJAX_NONCE)
			)
		);

		$scriptData = array(
			'jsFiles' => apply_filters('sgpbFrontendJsFiles', $jsFiles),
			'localizeData' => apply_filters('sgpbFrontendJsLocalizedData', $localizeData)
		);

		$scriptData = apply_filters('sgpbFrontendJs', $scriptData);

		return $scriptData;
	}

	public function getFrontendStyles($page, $data)
	{
		$cssFiles = array();
		$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'theme.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
		$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'animate.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);

		$cssData = array(
			'cssFiles' => apply_filters('sgpbFrontendCssFiles', $cssFiles)
		);

		return $cssData;
	}
}
