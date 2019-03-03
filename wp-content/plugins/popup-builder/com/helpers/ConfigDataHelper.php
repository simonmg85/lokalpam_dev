<?php
class ConfigDataHelper
{
	public static $customPostType;

	public static function getPostTypeData($args = array())
	{
		$query = self::getQueryDataByArgs($args);

		$posts = array();
		foreach ($query->posts as $post) {
			$posts[$post->ID] = $post->post_title;
		}

		return $posts;
	}

	public static function getQueryDataByArgs($args = array())
	{
		$defaultArgs = array(
			'offset'           =>  0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_status'      => 'publish',
			'suppress_filters' => true,
			'post_type'        => 'post',
			'posts_per_page'   => 1000
		);

		$args = wp_parse_args($args, $defaultArgs);
		$query = new WP_Query($args);

		return $query;
	}

	private static function getAllCustomPosts()
	{
		$args = array(
			'public' => true,
			'_builtin' => false
		);

		$allCustomPosts = get_post_types($args);
		if (isset($allCustomPosts[SG_POPUP_POST_TYPE])) {
			unset($allCustomPosts[SG_POPUP_POST_TYPE]);
		}
		return $allCustomPosts;
	}

	public static function addFilters()
	{
		self::addPostTypeToFilters();
	}

	private static function addPostTypeToFilters()
	{
		add_filter('sgPopupTargetParams', array(__CLASS__, 'addPopupTargetParams'), 1, 1);
		add_filter('sgPopupTargetData', array(__CLASS__, 'addPopupTargetData'), 1, 1);
		add_filter('sgPopupTargetTypes', array(__CLASS__, 'addPopupTargetTypes'), 1, 1);
		add_filter('sgPopupTargetAttrs', array(__CLASS__, 'addPopupTargetAttrs'), 1, 1);
		add_filter('sgPopupPageTemplates', array(__CLASS__, 'addPopupPageTemplates'), 1, 1);
	}

	public static function addPopupTargetParams($targetParams)
	{
		$allCustomPostTypes = self::getAllCustomPosts();

		foreach ($allCustomPostTypes as $customPostType) {
			$targetParams[$customPostType] = array(
				$customPostType.'_all' => 'All '.ucfirst($customPostType).'s',
				$customPostType.'_selected' => 'Select '.ucfirst($customPostType).'s'
			);
		}

		return $targetParams;
	}

	public static function addPopupTargetData($targetData)
	{
		$allCustomPostTypes = self::getAllCustomPosts();

		foreach ($allCustomPostTypes as $customPostType) {
			$targetData[$customPostType.'_all'] = null;
			$targetData[$customPostType.'_selected'] = '';
		}

		return $targetData;
	}

	public static function addPopupTargetTypes($targetTypes)
	{
		$allCustomPostTypes = self::getAllCustomPosts();

		foreach ($allCustomPostTypes as $customPostType) {
			$targetTypes[$customPostType.'_selected'] = 'select';
		}

		return $targetTypes;
	}

	public static function addPopupTargetAttrs($targetAttrs)
	{
		$allCustomPostTypes = self::getAllCustomPosts();

		foreach ($allCustomPostTypes as $customPostType) {
			$targetAttrs[$customPostType.'_selected']['htmlAttrs'] = array('class' => 'js-sg-select2 js-select-ajax', 'data-select-class' => 'js-select-ajax', 'data-select-type' => 'ajax', 'data-value-param' => $customPostType, 'multiple' => 'multiple');
			$targetAttrs[$customPostType.'_selected']['infoAttrs'] = array('label' => __('Select ', SG_POPUP_TEXT_DOMAIN).$customPostType);
		}

		return $targetAttrs;
	}

	public static function addPopupPageTemplates($templates)
	{
		$pageTemplates = self::getPageTemplates();

		$pageTemplates += $templates;

		return $pageTemplates;
	}

	public static function getAllCustomPostTypes()
	{
		$args = array(
			'public' => true,
			'_builtin' => false
		);

		$allCustomPosts = get_post_types($args);
		if (!empty($allCustomPosts[SG_POPUP_POST_TYPE])) {
			unset($allCustomPosts[SG_POPUP_POST_TYPE]);
		}

		return $allCustomPosts;
	}

	public static function getPostsAllCategories()
	{

		$cats =  get_categories(
			array(
				'hide_empty' => 0,
				'type'      => 'post',
				'orderby'   => 'name',
				'order'     => 'ASC'
			)
		);
		$catsParams = array();
		foreach ($cats as $cat) {

			$id = $cat->term_id;
			$name = $cat->name;
			$catsParams[$id] = $name;
		}

		return $catsParams;
	}

	public static function getPageTypes()
	{
		$postTypes = array();

		$postTypes['is_home_page'] = __('Home Page', SG_POPUP_TEXT_DOMAIN);
		$postTypes['is_home'] = __('Posts Page', SG_POPUP_TEXT_DOMAIN);
		$postTypes['is_search'] = __('Search Pages', SG_POPUP_TEXT_DOMAIN);
		$postTypes['is_404'] = __('404 Pages', SG_POPUP_TEXT_DOMAIN);

		return $postTypes;
	}

	public static function getDevices()
	{
		$devices = array();

		$devices['is_desktop'] = __('Desktop', SG_POPUP_TEXT_DOMAIN);
		$devices['is_tablet'] = __('Tablet', SG_POPUP_TEXT_DOMAIN);
		$devices['is_mobile'] = __('Mobile', SG_POPUP_TEXT_DOMAIN);
		$devices['is_bot'] = __('Bots', SG_POPUP_TEXT_DOMAIN);

		return $devices;
	}

	public static function getPageTemplates()
	{
		$pageTemplates = array(
			'page.php' => __('Default Template', SG_POPUP_TEXT_DOMAIN)
		);

		$templates = wp_get_theme()->get_page_templates();
		if (empty($templates)) {
			return $pageTemplates;
		}

		foreach ($templates as $key => $value) {
			$pageTemplates[$key] = $value;
		}

		return $pageTemplates;
	}

	public static function getAllTags()
	{
		$allTags = array();
		$tags = get_tags(array(
			'hide_empty' => false
		));

		foreach ($tags as $tag) {
			$allTags[$tag->slug] = $tag->name;
		}

		return $allTags;
	}

	public static function defaultData()
	{
		$data = array();

		$data['contentClickOptions'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-7 sgpb-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-5 sgpb-choice-option-wrapper sgpb-sub-option-label'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group sgpb-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-content-click-behavior',
						'value' => 'close'
					),
					'label' => array(
						'name' => __('Close Popup', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-content-click-behavior',
						'data-attr-href' => 'content-click-redirect',
						'value' => 'redirect'
					),
					'label' => array(
						'name' => __('Redirect', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-content-click-behavior',
						'data-attr-href' => 'content-copy-to-clipboard',
						'value' => 'copy'
					),
					'label' => array(
						'name' => __('Copy to clipboard', SG_POPUP_TEXT_DOMAIN).':'
					)
				)
			)
		);

		$data['popupDimensions'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-7 sgpb-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-5 sgpb-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group sgpb-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-popup-dimension-mode',
						'class' => 'test class',
						'data-attr-href' => 'responsive-dimension-wrapper',
						'value' => 'responsiveMode'
					),
					'label' => array(
						'name' => __('Responsive mode', SG_POPUP_TEXT_DOMAIN).':',
						'info' => __('The sizes of the popup will be counted automatically, according to the content size of the popup. You can select the size in percentages, with this mode, to specify the size on the screen', SG_POPUP_TEXT_DOMAIN).'.'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-popup-dimension-mode',
						'class' => 'test class',
						'data-attr-href' => 'custom-dimension-wrapper',
						'value' => 'customMode'
					),
					'label' => array(
						'name' => __('Custom mode', SG_POPUP_TEXT_DOMAIN).':',
						'info' => __('Add your own custom dimensions for the popup to get the exact sizing for your popup', SG_POPUP_TEXT_DOMAIN).'.'
					)
				)
			)
		);

		$data['theme'] = array(
			array(
				'value' => 'sgpb-theme-1',
				'data-attributes' => array(
					'class' => 'js-sgpb-popup-themes',
					'data-popup-theme-number' => 1
				)
			),
			array(
				'value' => 'sgpb-theme-2',
				'data-attributes' => array(
					'class' => 'js-sgpb-popup-themes',
					'data-popup-theme-number' => 2
				)
			),
			array(
				'value' => 'sgpb-theme-3',
				'data-attributes' => array(
					'class' => 'js-sgpb-popup-themes',
					'data-popup-theme-number' => 3
				)
			),
			array(
				'value' => 'sgpb-theme-4',
				'data-attributes' => array(
					'class' => 'js-sgpb-popup-themes',
					'data-popup-theme-number' => 4
				)
			),
			array(
				'value' => 'sgpb-theme-5',
				'data-attributes' => array(
					'class' => 'js-sgpb-popup-themes',
					'data-popup-theme-number' => 5
				)
			),
			array(
				'value' => 'sgpb-theme-6',
				'data-attributes' => array(
					'class' => 'js-sgpb-popup-themes',
					'data-popup-theme-number' => 6
				)
			)
		);

		$data['responsiveDimensions'] = array(
			'auto' =>  __('Auto', SG_POPUP_TEXT_DOMAIN),
			'10' => '10%',
			'20' => '20%',
			'30' => '30%',
			'40' => '40%',
			'50' => '50%',
			'60' => '60%',
			'70' => '70%',
			'80' => '80%',
			'90' => '90%',
			'100' => '100%'
		);

		$data['closeButtonPositions'] = array(
			'topLeft' => __('top-left', SG_POPUP_TEXT_DOMAIN),
			'topRight' => __('top-right', SG_POPUP_TEXT_DOMAIN),
			'bottomLeft' => __('bottom-left', SG_POPUP_TEXT_DOMAIN),
			'bottomRight' => __('bottom-right', SG_POPUP_TEXT_DOMAIN)
		);

		$data['closeButtonPositionsFirstTheme'] = array(
			'bottomLeft' => __('bottom-left', SG_POPUP_TEXT_DOMAIN),
			'bottomRight' => __('bottom-right', SG_POPUP_TEXT_DOMAIN)
		);

		$data['pxPercent'] = array(
			'px' => 'px',
			'%' => '%'
		);

		$data['countdownFormat'] = array(
			SG_COUNTDOWN_COUNTER_SECONDS_SHOW => 'DD:HH:MM:SS',
			SG_COUNTDOWN_COUNTER_SECONDS_HIDE => 'DD:HH:MM'
		);

		// proStartGoldproEndGold

		$data['countdownLanguage'] = array(
			'English'    => 'English',
			'German'     => 'Deutsche',
			'Spanish'    => 'Español',
			'Arabic'     => 'عربى',
			'Italian'    => 'Italiano',
			'Dutch'      => 'Dutch',
			'Norwegian'  => 'Norsk',
			'Portuguese' => 'Português',
			'Russian'    => 'Русский',
			'Swedish'    => 'Svenska',
			'Chinese'    => '中文'
		);

		$data['weekDaysArray'] = array(
			'Mon' => __('Monday', SG_POPUP_TEXT_DOMAIN),
			'Tue' => __('Tuesday', SG_POPUP_TEXT_DOMAIN),
			'Wed' => __('Wednesday', SG_POPUP_TEXT_DOMAIN),
			'Thu' => __('Thursday', SG_POPUP_TEXT_DOMAIN),
			'Fri' => __('Friday', SG_POPUP_TEXT_DOMAIN),
			'Sat' => __('Saturday', SG_POPUP_TEXT_DOMAIN),
			'Sun' => __('Sunday', SG_POPUP_TEXT_DOMAIN)
		);

		$data['messageResize'] = array(
			'both' => __('Both', SG_POPUP_TEXT_DOMAIN),
			'horizontal' => __('Horizontal', SG_POPUP_TEXT_DOMAIN),
			'vertical' => __('Vertical', SG_POPUP_TEXT_DOMAIN),
			'none' => __('None', SG_POPUP_TEXT_DOMAIN),
			'inherit' => __('Inherit', SG_POPUP_TEXT_DOMAIN)
		);

		$data['socialShareOptions'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-7 sgpb-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-5 sgpb-choice-option-wrapper'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group sgpb-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-social-share-url-type',
						'class' => 'sgpb-share-url-type',
						'data-attr-href' => '',
						'value' => 'activeUrl'
					),
					'label' => array(
						'name' => __('Use active URL', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-social-share-url-type',
						'class' => 'sgpb-share-url-type',
						'data-attr-href' => 'sgpb-social-share-url-wrapper',
						'value' => 'shareUrl'
					),
					'label' => array(
						'name' => __('Share URL', SG_POPUP_TEXT_DOMAIN).':'
					)
				)
			)
		);

		$data['popupInsertEventTypes'] = array(
			'inherit' => __('Inherit', SG_POPUP_TEXT_DOMAIN),
			'onLoad' => __('On load', SG_POPUP_TEXT_DOMAIN),
			'click' => __('On click', SG_POPUP_TEXT_DOMAIN),
			'hover' => __('On hover', SG_POPUP_TEXT_DOMAIN)
		);

		$data['subscriptionSuccessBehavior'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 sgpb-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 sgpb-choice-option-wrapper sgpb-sub-option-label'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group sgpb-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-subs-success-behavior',
						'class' => 'subs-success-message',
						'data-attr-href' => 'subs-show-success-message',
						'value' => 'showMessage'
					),
					'label' => array(
						'name' => __('Success message', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-subs-success-behavior',
						'class' => 'subs-redirect-to-URL',
						'data-attr-href' => 'subs-redirect-to-URL',
						'value' => 'redirectToURL'
					),
					'label' => array(
						'name' => __('Redirect to url', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-subs-success-behavior',
						'class' => 'subs-success-open-popup',
						'data-attr-href' => 'subs-open-popup',
						'value' => 'openPopup'
					),
					'label' => array(
						'name' => __('Open popup', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-subs-success-behavior',
						'class' => 'subs-hide-popup',
						'value' => 'hidePopup'
					),
					'label' => array(
						'name' => __('Hide popup', SG_POPUP_TEXT_DOMAIN).':'
					)
				)
			)
		);

		$data['contactFormSuccessBehavior'] = array(
			'template' => array(
				'fieldWrapperAttr' => array(
					'class' => 'col-md-6 sgpb-choice-option-wrapper'
				),
				'labelAttr' => array(
					'class' => 'col-md-6 sgpb-choice-option-wrapper sgpb-sub-option-label'
				),
				'groupWrapperAttr' => array(
					'class' => 'row form-group sgpb-choice-wrapper'
				)
			),
			'buttonPosition' => 'right',
			'nextNewLine' => true,
			'fields' => array(
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-contact-success-behavior',
						'class' => 'contact-success-message',
						'data-attr-href' => 'contact-show-success-message',
						'value' => 'showMessage'
					),
					'label' => array(
						'name' => __('Success message', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-contact-success-behavior',
						'class' => 'contact-redirect-to-URL ok-ggoel',
						'data-attr-href' => 'contact-redirect-to-URL',
						'value' => 'redirectToURL'
					),
					'label' => array(
						'name' => __('Redirect to url', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-contact-success-behavior',
						'class' => 'contact-success-open-popup',
						'data-attr-href' => 'contact-open-popup',
						'value' => 'openPopup'
					),
					'label' => array(
						'name' => __('Open popup', SG_POPUP_TEXT_DOMAIN).':'
					)
				),
				array(
					'attr' => array(
						'type' => 'radio',
						'name' => 'sgpb-contact-success-behavior',
						'class' => 'contact-hide-popup',
						'value' => 'hidePopup'
					),
					'label' => array(
						'name' => __('Hide popup', SG_POPUP_TEXT_DOMAIN).':'
					)
				)
			)
		);

		$data['socialShareTheme'] = array(
			'flat' => __('Flat', SG_POPUP_TEXT_DOMAIN),
			'classic' => __('Classic', SG_POPUP_TEXT_DOMAIN),
			'minima' => __('Minima', SG_POPUP_TEXT_DOMAIN),
			'plain' => __('Plain', SG_POPUP_TEXT_DOMAIN)
		);

		$data['socialThemeSizes'] = array(
			'8' => '8',
			'10' => '10',
			'12' => '12',
			'14' => '14',
			'16' => '16',
			'18' => '18',
			'20' => '20',
			'24' => '24'
		);

		$data['socialThemeShereCount'] = array(
			'true' => __('True', SG_POPUP_TEXT_DOMAIN),
			'false' => __('False', SG_POPUP_TEXT_DOMAIN),
			'inside' => __('Inside', SG_POPUP_TEXT_DOMAIN)
		);

		$data['buttonsType'] = array(
			'standard' => __('Standard', SG_POPUP_TEXT_DOMAIN),
			'box_count' => __('Box with count', SG_POPUP_TEXT_DOMAIN),
			'button_count' => __('Button with count', SG_POPUP_TEXT_DOMAIN),
			'button' => __('Button', SG_POPUP_TEXT_DOMAIN)
		);

		$data['backroundImageModes'] = array(
			'no-repeat' => __('None', SG_POPUP_TEXT_DOMAIN),
			'cover' => __('Cover', SG_POPUP_TEXT_DOMAIN),
			'fit' => __('Fit', SG_POPUP_TEXT_DOMAIN),
			'contain' => __('Contain', SG_POPUP_TEXT_DOMAIN),
			'repeat' => __('Repeat', SG_POPUP_TEXT_DOMAIN)
		);

		$data['openAnimationEfects'] = array(
			'No effect' => __('None', SG_POPUP_TEXT_DOMAIN),
			'sgpb-flip' => __('Flip', SG_POPUP_TEXT_DOMAIN),
			'sgpb-shake' => __('Shake', SG_POPUP_TEXT_DOMAIN),
			'sgpb-wobble' => __('Wobble', SG_POPUP_TEXT_DOMAIN),
			'sgpb-swing' => __('Swing', SG_POPUP_TEXT_DOMAIN),
			'sgpb-flash' => __('Flash', SG_POPUP_TEXT_DOMAIN),
			'sgpb-bounce' => __('Bounce', SG_POPUP_TEXT_DOMAIN),
			'sgpb-bounceInRight' => __('BounceInRight', SG_POPUP_TEXT_DOMAIN),
			'sgpb-bounceIn' => __('BounceIn', SG_POPUP_TEXT_DOMAIN),
			'sgpb-pulse' => __('Pulse', SG_POPUP_TEXT_DOMAIN),
			'sgpb-rubberBand' => __('RubberBand', SG_POPUP_TEXT_DOMAIN),
			'sgpb-tada' => __('Tada', SG_POPUP_TEXT_DOMAIN),
			'sgpb-slideInUp' => __('SlideInUp', SG_POPUP_TEXT_DOMAIN),
			'sgpb-jello' => __('Jello', SG_POPUP_TEXT_DOMAIN),
			'sgpb-rotateIn' => __('RotateIn', SG_POPUP_TEXT_DOMAIN),
			'sgpb-fadeIn' => __('FadeIn', SG_POPUP_TEXT_DOMAIN)
		);

		$data['userRoles'] = self::getAllUserRoles();

		return $data;
	}

	public static function getAllUserRoles()
	{
		$rulesArray = array();
		if (!function_exists('get_editable_roles')){
			return $rulesArray;
		}

		$roles = get_editable_roles();
		foreach ($roles as $roleName => $roleInfo) {
			if ($roleName == 'administrator') {
				continue;
			}
			$rulesArray[$roleName] = $roleName;
		}

		return $rulesArray;
	}

	public static function countriesIsoData()
	{
		$countries = array (
			'AF' => 'Afghanistan',
			'AX' => 'Aland Islands',
			'AL' => 'Albania',
			'DZ' => 'Algeria',
			'AS' => 'American Samoa',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica',
			'AG' => 'Antigua And Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaijan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BO' => 'Bolivia',
			'BA' => 'Bosnia And Herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'BN' => 'Brunei Darussalam',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodia',
			'CM' => 'Cameroon',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic',
			'TD' => 'Chad',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island',
			'CC' => 'Cocos (Keeling) Islands',
			'CO' => 'Colombia',
			'KM' => 'Comoros',
			'CG' => 'Congo',
			'CD' => 'Congo, Democratic Republic',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'CI' => "Cote D'Ivoire",
			'HR' => 'Croatia',
			'CU' => 'Cuba',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'SV' => 'El Salvador',
			'GQ' => 'Equatorial Guinea',
			'ER' => 'Eritrea',
			'EE' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands (Malvinas)',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'GT' => 'Guatemala',
			'GG' => 'Guernsey',
			'GN' => 'Guinea',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haiti',
			'HM' => 'Heard Island & Mcdonald Islands',
			'VA' => 'Holy See (Vatican City State)',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Islamic Republic of Iran',
			'IQ' => 'Iraq',
			'IE' => 'Ireland',
			'IM' => 'Isle Of Man',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JE' => 'Jersey',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KI' => 'Kiribati',
			'KR' => 'Korea',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => "Lao People's Democratic Republic",
			'LV' => 'Latvia',
			'LB' => 'Lebanon',
			'LS' => 'Lesotho',
			'LR' => 'Liberia',
			'LY' => 'Libyan Arab Jamahiriya',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macao',
			'MK' => 'Macedonia',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia, Federated States Of',
			'MD' => 'Moldova',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'MM' => 'Myanmar',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'MP' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PK' => 'Pakistan',
			'PW' => 'Palau',
			'PS' => 'Palestinian Territory, Occupied',
			'PA' => 'Panama',
			'PG' => 'Papua New Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'PR' => 'Puerto Rico',
			'QA' => 'Qatar',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'BL' => 'Saint Barthelemy',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts And Nevis',
			'LC' => 'Saint Lucia',
			'MF' => 'Saint Martin',
			'PM' => 'Saint Pierre And Miquelon',
			'VC' => 'Saint Vincent And Grenadines',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'ST' => 'Sao Tome And Principe',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'RS' => 'Serbia',
			'SC' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'SO' => 'Somalia',
			'ZA' => 'South Africa',
			'GS' => 'South Georgia And Sandwich Isl.',
			'ES' => 'Spain',
			'LK' => 'Sri Lanka',
			'SD' => 'Sudan',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard And Jan Mayen',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'SY' => 'Syrian Arab Republic',
			'TW' => 'Taiwan',
			'TJ' => 'Tajikistan',
			'TZ' => 'Tanzania',
			'TH' => 'Thailand',
			'TL' => 'Timor-Leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad And Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks And Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'GB' => 'United Kingdom',
			'US' => 'United States',
			'UM' => 'United States Outlying Islands',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VE' => 'Venezuela',
			'VN' => 'Viet Nam',
			'VG' => 'Virgin Islands, British',
			'VI' => 'Virgin Islands, U.S.',
			'WF' => 'Wallis And Futuna',
			'EH' => 'Western Sahara',
			'YE' => 'Yemen',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe',
		);

		return $countries;
	}

	// proStartSilverproEndSilver

	// proStartGoldproEndGold

	public static function getJsLocalizedData()
	{
		$translatedData = array(
			'imageSupportAlertMessage' => __('Only image files supported', SG_POPUP_TEXT_DOMAIN),
			'areYouSure' => __('Are you sure?', SG_POPUP_TEXT_DOMAIN),
			'addButtonSpinner' => __('Add', SG_POPUP_TEXT_DOMAIN),
			'audioSupportAlertMessage' => __('Only audio files supported (e.g.: mp3, wav, m4a, ogg)', SG_POPUP_TEXT_DOMAIN)
		);

		return $translatedData;
	}
}
