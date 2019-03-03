<?php
require_once(SG_POPUP_HELPERS_PATH.'ConfigDataHelper.php');
use sgpb\PopupBuilderActivePackage;
class SgpbDataConfig
{
	public static function init()
	{
		self::addFilters();
		self::conditionInit();
		self::popupDefaultOptions();
	}

	public static function conditionInit()
	{
		global $SGPB_DATA_CONFIG_ARRAY;

		/*Target condition config*/
		$targetData = array('param' => 'Pages', 'operator' => 'Is not', 'value' => 'Value');
		$targetElementTypes = array(
			'param' => 'select',
			'operator' => 'select',
			'value' => 'select',
			'post_selected' => 'select',
			'page_selected' => 'select',
			'post_type' => 'select',
			'post_category' => 'select',
			'page_type' => 'select',
			'page_template' => 'select',
			'post_tags_ids' => 'select'
		);

		$targetParams = array(
			'not_rule' => __('Select rule', SG_POPUP_TEXT_DOMAIN),
			'Post' => array(
				'post_all' => __('All posts', SG_POPUP_TEXT_DOMAIN),
				'post_selected' => __('Selected posts', SG_POPUP_TEXT_DOMAIN),
				'post_type' => __('Post type', SG_POPUP_TEXT_DOMAIN),
				'post_category' => __('Post category', SG_POPUP_TEXT_DOMAIN)
			),
			'Page' => array(
				'page_all' => __('All pages', SG_POPUP_TEXT_DOMAIN),
				'page_selected' => __('Selected pages', SG_POPUP_TEXT_DOMAIN),
				'page_type' => __('Page type', SG_POPUP_TEXT_DOMAIN),
				'page_template' => __('Page template', SG_POPUP_TEXT_DOMAIN)
			),
			'Tags' => array(
				'post_tags' => __('All tags', SG_POPUP_TEXT_DOMAIN),
				'post_tags_ids' => __('Selected tags', SG_POPUP_TEXT_DOMAIN)
			)
		);

		$targetOperators = array(
			array('operator' => 'add', 'name' => __('Add', SG_POPUP_TEXT_DOMAIN)),
			array('operator' => 'delete', 'name' => __('Delete', SG_POPUP_TEXT_DOMAIN))
		);

		$targetDataOperator = array(
			'==' => __('Is', SG_POPUP_TEXT_DOMAIN),
			'!=' => __('Is not', SG_POPUP_TEXT_DOMAIN)
		);

		$targetInitialData = array(
			array('param' => 'not_rule', 'operator' => '==', 'value' => '')
		);

		$targetDataParams['param'] = apply_filters('sgPopupTargetParams', $targetParams);
		$targetDataParams['operator'] = apply_filters('sgPopupTargetOperator', $targetDataOperator);
		$targetDataParams['post_selected'] = apply_filters('sgPopupTargetPostData', array());
		$targetDataParams['page_selected'] = apply_filters('sgPopupTargetPageSelected', array());
		$targetDataParams['post_type'] = apply_filters('sgPopupTargetPostType', ConfigDataHelper::getAllCustomPostTypes());
		$targetDataParams['post_category'] = apply_filters('sgPopupTargetPostType', ConfigDataHelper::getPostsAllCategories());
		$targetDataParams['page_type'] = apply_filters('sgPopupTargetPostType', ConfigDataHelper::getPageTypes());
		$targetDataParams['page_template'] = apply_filters('sgPopupPageTemplates', array());
		$targetDataParams['post_tags_ids'] = apply_filters('sgPopupTags', ConfigDataHelper::getAllTags());
		$targetDataParams['not_rule'] = null;
		$targetDataParams['post_all'] = null;
		$targetDataParams['page_all'] = null;
		$targetDataParams['post_tags'] = null;

		$targetAttrs = array(
			'param' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic',
					'autocomplete' => 'off'
				),
				'infoAttrs' => array(
					'label' => 'Display rule',
					'info' => __('Specify where the popup should be shown on your site.', SG_POPUP_TEXT_DOMAIN)
				)

			),
			'operator' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => 'Is or is not',
					'info' => __('Allow or Disallow popup showing for the selected rule.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'post_selected' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'ajax',
					'data-value-param' => 'post',
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select Your Posts',
					'info' => __('Select your specific posts where the popup should be shown.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'page_selected' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'ajax',
					'data-value-param' => 'page',
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select Your Pages',
					'info' => __('Select the pages on your site where the specific popup will be shown.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'post_type' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'multiple',
					'data-value-param' => 'postTypes',
					'isNotPostType' => true,
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select Your post types',
					'info' => __('Specify the post types on your site to show the popup.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'post_category' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'multiple',
					'data-value-param' => 'postCategories',
					'isNotPostType' => true,
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select post categories',
					'info' => __('Select the post categories on which the popup should be shown.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'page_type' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'multiple',
					'data-value-param' => 'postCategories',
					'isNotPostType' => true,
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select specific page types',
					'info' => __('Specify the page types where the popup will be shown.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'page_template' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'multiple',
					'data-value-param' => 'pageTemplate',
					'isNotPostType' => true,
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select page template',
					'info' => __('Select the page templates on which the popup will be shown.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'post_tags_ids' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'multiple',
					'data-value-param' => 'postTags',
					'isNotPostType' => true,
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select tags',
					'info' => __('Select the tags on your site for popup showing', SG_POPUP_TEXT_DOMAIN)
				)
			)
		);

		$popupTarget['columns'] = apply_filters('sgPopupTargetColumns', $targetData);
		$popupTarget['columnTypes'] = apply_filters('sgPopupTargetTypes', $targetElementTypes);
		$popupTarget['paramsData'] = apply_filters('sgPopupTargetData', $targetDataParams);
		$popupTarget['initialData'] = apply_filters('sgPopupTargetInitialData', $targetInitialData);
		$popupTarget['operators'] = apply_filters('sgPopupTargetOperators', $targetOperators);
		$popupTarget['attrs'] = apply_filters('sgPopupTargetAttrs', $targetAttrs);

		$SGPB_DATA_CONFIG_ARRAY['target'] = $popupTarget;

		/*Target condition config*/

		/*
		 *
		 * Events data
		 *
		 **/
		$eventsData = array('param' => 'Event name', 'value' => 'Delay');
		$hiddenOptionData = array();

		$eventsRowTypes = array(
			'param' => 'select',
			'value' => 'text',
			'load' => 'number',
			'onScroll' => 'number',
			'inactivity' => 'number',
			'repetitive' => 'checkbox',
			'repetitivePeriod' => 'text',
		);

		$params = array(
			'load' => 'On load',
			'inactivity'=>'Inactivity',
			'onScroll'=> 'On scroll'
		);

		$hiddenOptionData['load'] = array(
			'options' => array(
				'repetitive' => 'Repetitive popup'
			)
		);

		$onLoadData = 0;
		$inactivityData = 0;
		$onScroll = 0;

		$eventsDataParams['param'] = $params;
		$eventsDataParams['load'] = $onLoadData;
		$eventsDataParams['onScroll'] = $onScroll;
		$eventsDataParams['inactivity'] = $inactivityData;
		/*Hidden params data*/
		$eventsDataParams['repetitive'] = '';
		$eventsDataParams['repetitivePeriod'] = 0;

		$eventOperators = array(
			array('operator' => 'add', 'name' => 'Add'),
			array('operator' => 'edit', 'name' => 'Edit'),
			array('operator' => 'delete', 'name' => 'Delete')
		);

		$eventsInitialData = array(
			array('param' => 'load', 'value' => '')
		);

		$eventsAttrs = array(
			'param' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic sgpb-selectbox-settings',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => 'Event',
					'info' => __('Select when the popup should appear on the page.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'operator' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => 'Select operator',
					'info' => __('This is info', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'load' => array(
				'htmlAttrs' => array('class' => 'js-sg-onload-text', 'placeholder' => __('default custom delay will be used', SG_POPUP_TEXT_DOMAIN), 'min' => 0),
				'infoAttrs' => array(
					'label' => 'Delay',
					'info' => __('Specify how long the popup appearance should be delayed after loading the page (in sec).', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'onScroll' => array(
				'htmlAttrs' => array('class' => 'js-sg-onScroll-text', 'min' => 0),
				'infoAttrs' => array(
					'label' => 'After x percent',
					'info' => __('Specify the part of the page, in percentages, where the popup should appear after scrolling.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'inactivity' => array(
				'htmlAttrs' => array('class' => 'js-sg-inactivity-text', 'min' => 0),
				'infoAttrs' => array(
					'label' => 'Delay',
					'info' => __('Show the popup after some time of inactivity. The popup will appear if a user does nothing for some specific time mentioned.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'repetitive' => array(
				'htmlAttrs' => array(
					'class' => 'sgpb-popup-option sgpb-popup-accordion',
					'data-name' => 'repetitive',
					'autocomplete' => 'off'
				),
				'infoAttrs' => array(
					'label' => 'Repetitive open popup',
					'info' => __('If this option is enabled the same popup will open up after every X seconds you have defined (after closing it).', SG_POPUP_TEXT_DOMAIN)
				),
				'childOptions' => array('repetitivePeriod')
			),
			'repetitivePeriod' => array(
				'htmlAttrs' => array(
					'class' => 'sgpb-popup-option',
					'autocomplete' => 'off'
				),
				'infoAttrs' => array(
					'label' => 'period',
					'info' => __('This is info', SG_POPUP_TEXT_DOMAIN)
				)
			)
		);

		$popupEvents['columns'] = apply_filters('sgPopupEventColumns', $eventsData);
		$popupEvents['columnTypes'] = apply_filters('sgPopupEventTypes', $eventsRowTypes);
		$popupEvents['paramsData'] = apply_filters('sgPopupEventsData', $eventsDataParams);
		$popupEvents['initialData'] = apply_filters('sgPopupEventsInitialData', $eventsInitialData);
		$popupEvents['operators'] = apply_filters('sgPopupEventOperators', $eventOperators);
		$popupEvents['hiddenOptionData'] = apply_filters('sgEventsHiddenData', $hiddenOptionData);
		$popupEvents['attrs'] = apply_filters('sgPopupEventAttrs', $eventsAttrs);

		$SGPB_DATA_CONFIG_ARRAY['events'] = $popupEvents;

		/*Target condition config*/
		$targetData = array('param' => 'Pages', 'operator' => 'Is not', 'value' => 'Value');
		$targetElementTypes = array(
			'param' => 'select',
			'operator' => 'select',
			'value' => 'select',
			'groups_user_role' => 'select',
			'select_role' => 'select',
			'groups_countries' => 'select',
			'groups_devices' => 'select'
		);

		$targetParams = array(
			'select_role' => __('Select role', SG_POPUP_TEXT_DOMAIN),
			'Groups' => array(
				'groups_user_role' => __('User status', SG_POPUP_TEXT_DOMAIN),
				'groups_countries' => __('Countries', SG_POPUP_TEXT_DOMAIN),
				'groups_devices' =>  __('Devices', SG_POPUP_TEXT_DOMAIN)
			)
		);

		$targetOperators = array(
			array('operator' => 'add', 'name' => __('Add', SG_POPUP_TEXT_DOMAIN)),
			array('operator' => 'delete', 'name' => __('Delete', SG_POPUP_TEXT_DOMAIN))
		);

		$targetDataOperator = array(
			'==' => __('Is', SG_POPUP_TEXT_DOMAIN),
			'!=' => __('Is not', SG_POPUP_TEXT_DOMAIN)
		);

		$targetInitialData = array(
			array('param' => 'select_role', 'operator' => '==', 'value' => '')
		);

		$userStatus = array(
			'loggedIn' => 	__('logged in', SG_POPUP_TEXT_DOMAIN)
		);
		$userStatusCanBeUsed = PopupBuilderActivePackage::canUseSection('userStatus');
		if (!$userStatusCanBeUsed) {
			unset($targetParams['Groups']['groups_user_role']);
			$userStatus = array();
		}

		$targetDataParams['param'] = apply_filters('sgPopupTargetParams', $targetParams);
		$targetDataParams['operator'] = apply_filters('sgPopupTargetOperator', $targetDataOperator);
		$targetDataParams['select_role'] = null;
		$targetDataParams['groups_user_role'] = apply_filters('sgPopupConditionsUserStatus', $userStatus);
		$targetDataParams['groups_countries'] = apply_filters('sgPopupConditionsCountries', ConfigDataHelper::countriesIsoData());
		$targetDataParams['groups_devices'] = apply_filters('sgPopupConditionsDevices', ConfigDataHelper::getDevices());

		$targetAttrs = array(
			'param' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic sgpb-selectbox-settings',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic',
					'autocomplete' => 'off'
				),
				'infoAttrs' => array(
					'label' => 'Condition',
					'info' => __('Target visitors to show the popup by different conditions.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'operator' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => 'Page operator',
					'info' => __('Allow or Disallow popup showing for the selected conditions.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'groups_user_role' => array(
				'htmlAttrs' => 	array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => 'Select user role',
					'info' => __('Set up the popup to allow it for logged-in or logged-out users.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'groups_countries' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic',
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select countries',
					'info' => __('Select the countries for which the popup will be shown or hidden.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'groups_devices' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic',
					'multiple' => 'multiple'
				),
				'infoAttrs' => array(
					'label' => 'Select user devices',
					'info' => __('Select the device for which the popup will be available.', SG_POPUP_TEXT_DOMAIN)
				)
			)
		);

		$popupConditions['columns'] = apply_filters('sgPopupConditionsColumns', $targetData);
		$popupConditions['columnTypes'] = apply_filters('sgPopupConditionsTypes', $targetElementTypes);
		$popupConditions['paramsData'] = apply_filters('sgPopupConditionsData', $targetDataParams);
		$popupConditions['initialData'] = apply_filters('sgPopupConditionsInitialData', $targetInitialData);
		$popupConditions['operators'] = apply_filters('sgPopupConditionsOperators', $targetOperators);
		$popupConditions['attrs'] = apply_filters('sgPopupConditionsAttrs', $targetAttrs);

		$SGPB_DATA_CONFIG_ARRAY['conditions'] = $popupConditions;

		$SGPB_DATA_CONFIG_ARRAY['behavior-after-special-events'] = self::getBehaviorAfterSpecialEventsConfig();
		/*Target condition config*/
	}

	public static function allExtensionsKeys()
	{
		$keys = array();

		$keys[] = array(
			'label' => __('AdBlock', SG_POPUP_TEXT_DOMAIN),
			'pluginKey' => 'popupbuilder-adblock/PopupBuilderAdBlock.php',
			'key' => 'sgpbAdBlock',
			'url' => SG_POPUP_AD_BLOCK_URL
		);
		$keys[] = array(
			'label' => __('Analytics', SG_POPUP_TEXT_DOMAIN),
			'pluginKey' => 'popupbuilder-analytics/PopupBuilderAnalytics.php',
			'key' => 'sgpbAnalitics',
			'url' => SG_POPUP_ANALYTICS_URL
		);
		$keys[] = array(
			'label' => __('Exit Intent',SG_POPUP_TEXT_DOMAIN),
			'pluginKey' => 'popupbuilder-exit-intent/PopupBuilderExitIntent.php',
			'key' => 'sgpbExitIntent',
			'url' => SG_POPUP_EXIT_INTENT_URL
		);
		$keys[] = array(
			'label' => __('MailChimp', SG_POPUP_TEXT_DOMAIN),
			'pluginKey' => 'popupbuilder-mailchimp/PopupBuilderMailchimp.php',
			'key' => 'sgpbMailchimp',
			'url' => SG_POPUP_MAILCHIMP_URL
		);
		$keys[] = array(
			'label' => __('AWeber', SG_POPUP_TEXT_DOMAIN),
			'pluginKey' =>  'popupbuilder-aweber/PopupBuilderAWeber.php',
			'key' => 'sgpbAWeber',
			'url' => SG_POPUP_AWEBER_URL
		);

		return apply_filters('sgpbExtensionsKeys', $keys);
	}

	private static function getBehaviorAfterSpecialEventsConfig()
	{
		$columns = array(
			'param' => 'Event',
			'operator' => 'Behavior',
			'value' => 'Value'
		);

		$columnTypes = array(
			'param' => 'select',
			'operator' => 'select',
			'value' => 'select',
			'select_event' => 'select',
			'select_behavior' => 'select',
			'redirect-url' => 'url',
			'open-popup' => 'select',
			'close-popup' => 'number'
		);

		$params = array(
			'param' => array(
				'select_event' => __('Select event', SG_POPUP_TEXT_DOMAIN),
				__('Special events', SG_POPUP_TEXT_DOMAIN) => array(
					SGPB_CONTACT_FORM_7_BEHAVIOR_KEY => __('Contact Form 7 submission', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'operator' => array(
				'select_behavior' => __('Select behavior', SG_POPUP_TEXT_DOMAIN),
				__('Behaviors', SG_POPUP_TEXT_DOMAIN) => array(
					'redirect-url' => __('Redirect to url', SG_POPUP_TEXT_DOMAIN),
					'open-popup' => __('Open another popup', SG_POPUP_TEXT_DOMAIN),
					'close-popup' => __('Close current popup', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'redirect-url' => '',
			'open-popup' => array(),
			'close-popup' => '',
			'select_event' => null,
			'select_behavior' => null
		);

		$initialData = array(
			array(
				'param' => 'select_event',
				'operator' => ''
			)
		);

		$attrs = array(
			'param' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => __('Event', SG_POPUP_TEXT_DOMAIN),
					'info' => __('Select the special event you want to catch.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'operator' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-basic',
					'data-select-class' => 'js-select-basic',
					'data-select-type' => 'basic'
				),
				'infoAttrs' => array(
					'label' => __('Behavior', SG_POPUP_TEXT_DOMAIN),
					'info' => __('Select what should happen after the special event.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'redirect-url' => array(
				'htmlAttrs' => array(
					'class' => 'sg-full-width',
					'placeholder' => 'https://www.example.com',
					'required' => 'required'
				),
				'infoAttrs' => array(
					'label' => __('URL', SG_POPUP_TEXT_DOMAIN),
					'info' => __('Enter the URL of the page should be redirected to.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'open-popup' => array(
				'htmlAttrs' => array(
					'class' => 'js-sg-select2 js-select-ajax',
					'data-select-class' => 'js-select-ajax',
					'data-select-type' => 'ajax',
					'data-value-param' => SG_POPUP_POST_TYPE,
					'required' => 'required'
				),
				'infoAttrs' => array(
					'label' => __('Select popup', SG_POPUP_TEXT_DOMAIN),
					'info' => __('Select the popup that should be opened.', SG_POPUP_TEXT_DOMAIN)
				)
			),
			'close-popup' => array(
				'htmlAttrs' => array(
					'class' => 'sg-full-width',
					'required' => 'required',
					'value' => 0,
					'min' => 0
				),
				'infoAttrs' => array(
					'label' => __('Delay', SG_POPUP_TEXT_DOMAIN),
					'info' => __('After how many seconds the popup should close.', SG_POPUP_TEXT_DOMAIN)
				)
			)
		);

		$config = array();
		$config['columns'] = apply_filters('sgPopupSpecialEventsColumns', $columns);
		$config['columnTypes'] = apply_filters('sgPopupSpecialEventsColumnTypes', $columnTypes);
		$config['paramsData'] = apply_filters('sgPopupSpecialEventsParams', $params);
		$config['initialData'] = apply_filters('sgPopupSpecialEventsInitialData', $initialData);
		$config['attrs'] = apply_filters('sgPopupSpecialEventsAttrs', $attrs);
		$config['operators'] = apply_filters('sgPopupSpecialEventsOperators', array());

		return $config;
	}

	public static function popupDefaultOptions()
	{
		global $SGPB_OPTIONS;
		global $SGPB_DATA_CONFIG_ARRAY;

		$targetDefaultValue = array($SGPB_DATA_CONFIG_ARRAY['target']['initialData']);

		$eventsDefaultData = array($SGPB_DATA_CONFIG_ARRAY['events']['initialData']);
		$conditionsDefaultData = array($SGPB_DATA_CONFIG_ARRAY['conditions']['initialData']);
		$specialEventsDefaultData = array($SGPB_DATA_CONFIG_ARRAY['behavior-after-special-events']['initialData']);

		$options = array();

		$options[] = array('name' => 'sgpb-target', 'type' => 'array', 'defaultValue' => $targetDefaultValue);
		$options[] = array('name' => 'sgpb-events', 'type' => 'array', 'defaultValue' => $eventsDefaultData);
		$options[] = array('name' => 'sgpb-conditions', 'type' => 'array', 'defaultValue' => $conditionsDefaultData, 'min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER);
		$options[] = array('name' => 'sgpb-behavior-after-special-events', 'type' => 'array', 'defaultValue' => $specialEventsDefaultData);
		$options[] = array('name' => 'sgpb-type', 'type' => 'text', 'defaultValue' => 'html');
		$options[] = array('name' => 'sgpb-esc-key', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'sgpb-enable-close-button', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'sgpb-enable-content-scrolling', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'sgpb-overlay-click', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'sgpb-content-click', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-content-click-behavior', 'type' => 'text', 'defaultValue' => 'close');
		$options[] = array('name' => 'sgpb-click-redirect-to-url', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-redirect-to-new-tab', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-copy-to-clipboard-text', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-disable-popup-closing', 'type' => 'checkbox', 'defaultValue' => '', 'min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER);
		$options[] = array('name' => 'sgpb-popup-dimension-mode', 'type' => 'text', 'defaultValue' => 'responsiveMode');
		$options[] = array('name' => 'sgpb-popup-dimension-mode', 'type' => 'text', 'defaultValue' => '100');
		$options[] = array('name' => 'sgpb-width', 'type' => 'text', 'defaultValue' => '640px');
		$options[] = array('name' => 'sgpb-height', 'type' => 'text', 'defaultValue' => '480px');
		$options[] = array('name' => 'sgpb-max-width', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-max-height', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-min-width', 'type' => 'text', 'defaultValue' => '120');
		$options[] = array('name' => 'sgpb-min-height', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-schedule-status', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-schedule-weeks', 'type' => 'array', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-schedule-start-time', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-schedule-end-time', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-popup-timer-status', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-popup-start-timer', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-popup-end-timer', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-popup-fixed', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-popup-fixed-position', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-popup-delay', 'type' => 'text', 'defaultValue' => '0');
		$options[] = array('name' => 'sgpb-popup-order', 'type' => 'text', 'defaultValue' => '0');
		$options[] = array('name' => 'sgpb-disable-page-scrolling', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-content-padding', 'type' => 'text', 'defaultValue' => 7);
		$options[] = array('name' => 'sgpb-popup-z-index', 'type' => 'text', 'defaultValue' => 9999);
		$options[] = array('name' => 'sgpb-content-custom-class', 'type' => 'text', 'defaultValue' => 'sg-popup-content');
		$options[] = array('name' => 'sgpb-auto-close', 'type' => 'checkbox', 'defaultValue' => '', 'min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER);
		$options[] = array('name' => 'sgpb-auto-close-time', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'sgpb-reopen-after-form-submission', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-open-sound', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-sound-url', 'type' => 'text', 'defaultValue' => SG_POPUP_SOUND_URL.SGPB_POPUP_DEFAULT_SOUND);
		$options[] = array('name' => 'sgpb-open-animation', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-open-animation-speed', 'type' => 'text', 'defaultValue' => 1);
		$options[] = array('name' => 'sgpb-popup-themes', 'type' => 'text', 'defaultValue' => 'sgpb-theme-1');
		$options[] = array('name' => 'sgpb-enable-popup-overlay', 'type' => 'checkbox', 'defaultValue' => 'on', 'min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER);
		$options[] = array('name' => 'sgpb-overlay-custom-class', 'type' => 'text', 'defaultValue' => 'sgpb-popup-overlay');
		$options[] = array('name' => 'sgpb-overlay-color', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-background-color', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-overlay-opacity', 'type' => 'text', 'defaultValue' => 0.8);
		$options[] = array('name' => 'sgpb-content-opacity', 'type' => 'text', 'defaultValue' => 0.8);
		$options[] = array('name' => 'sgpb-iframe-url', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-iframe-invalid-url', 'type' => 'text', 'defaultValue' => __('Invalid URL.', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-iframe-protocol-warning', 'type' => 'text', 'defaultValue' => __('This url may not work, as it is HTTP and you are running HTTPS.', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-iframe-same-origin-warning', 'type' => 'text', 'defaultValue' => __('This url may not work, as it doesn\'t allow embedding in iframes.', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-background-image', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-show-background', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-background-image-mode', 'type' => 'text', 'defaultValue' => 'no-repeat');
		$options[] = array('name' => 'sgpb-image-url', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-close-button-delay', 'type' => 'number', 'defaultValue' => 0);
		$options[] = array('name' => 'sgpb-button-image', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-button-image-width', 'type' => 'text', 'defaultValue' => 21);
		$options[] = array('name' => 'sgpb-button-image-height', 'type' => 'text', 'defaultValue' => 21);
		$options[] = array('name' => 'sgpb-video-autoplay', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-video-invalid-url', 'type' => 'text', 'defaultValue' => __('Invalid URL', SG_POPUP_TEXT_DOMAIN).'.');
		$options[] = array('name' => 'sgpb-video-not-supported-url', 'type' => 'text', 'defaultValue' => __('This video URL is not supported', SG_POPUP_TEXT_DOMAIN).'.');
		$options[] = array('name' => 'sgpb-is-active', 'type' => 'checkbox', 'defaultValue' => 'on');
		// proStartSilverproEndSilver
		$options[] = array('name' => 'sgpb-subs-form-bg-color', 'type' => 'text', 'defaultValue' => '#FFFFFF');
		$options[] = array('name' => 'sgpb-subs-form-bg-opacity', 'type' => 'text', 'defaultValue' => 0.8);
		$options[] = array('name' => 'sgpb-subs-form-padding', 'type' => 'number', 'defaultValue' => 2);
		$options[] = array('name' => 'sgpb-subs-email-placeholder', 'type' => 'text', 'defaultValue' => __('Email *', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-first-name-status', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'sgpb-subs-first-placeholder', 'type' => 'text', 'defaultValue' => __('First name', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-first-name-required', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-subs-last-name-status', 'type' => 'checkbox', 'defaultValue' => 'on');
		$options[] = array('name' => 'sgpb-subs-last-placeholder', 'type' => 'text', 'defaultValue' => __('Last name', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-last-name-required', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-subs-validation-message', 'type' => 'text', 'defaultValue' => __('This field is required.', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-text-width', 'type' => 'text', 'defaultValue' => '300px');
		$options[] = array('name' => 'sgpb-subs-text-height', 'type' => 'text', 'defaultValue' => '40px');
		$options[] = array('name' => 'sgpb-subs-text-border-width', 'type' => 'text', 'defaultValue' => '2px');
		$options[] = array('name' => 'sgpb-subs-text-border-color', 'type' => 'text', 'defaultValue' => '#CCCCCC');
		$options[] = array('name' => 'sgpb-subs-text-bg-color', 'type' => 'text', 'defaultValue' => '#FFFFFF');
		$options[] = array('name' => 'sgpb-subs-text-color', 'type' => 'text', 'defaultValue' => '#000000');
		$options[] = array('name' => 'sgpb-subs-text-placeholder-color', 'type' => 'text', 'defaultValue' => '#CCCCCC');
		$options[] = array('name' => 'sgpb-subs-btn-width', 'type' => 'text', 'defaultValue' => '300px');
		$options[] = array('name' => 'sgpb-subs-btn-height', 'type' => 'text', 'defaultValue' => '40px');
		$options[] = array('name' => 'sgpb-subs-btn-title', 'type' => 'text', 'defaultValue' => __('Subscribe', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-btn-progress-title', 'type' => 'text', 'defaultValue' => __('Please wait...', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-btn-bg-color', 'type' => 'text', 'defaultValue' => '#4CAF50');
		$options[] = array('name' => 'sgpb-subs-btn-text-color', 'type' => 'text', 'defaultValue' => '#FFFFFF');
		$options[] = array('name' => 'sgpb-subs-error-message', 'type' => 'text', 'defaultValue' => __('There was an error while trying to send your request. Please try again', SG_POPUP_TEXT_DOMAIN).'.');
		$options[] = array('name' => 'sgpb-subs-invalid-message', 'type' => 'text', 'defaultValue' => __('Please enter a valid email address', SG_POPUP_TEXT_DOMAIN).'.');
		$options[] = array('name' => 'sgpb-subs-success-behavior', 'type' => 'text', 'defaultValue' => 'showMessage');
		$options[] = array('name' => 'sgpb-subs-success-message', 'type' => 'text', 'defaultValue' =>  __('You have successfully subscribed to the newsletter', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-success-redirect-URL', 'type' => 'text', 'defaultValue' =>  '');
		$options[] = array('name' => 'sgpb-subs-success-redirect-new-tab', 'type' => 'checkbox', 'defaultValue' =>  '');
		$options[] = array('name' => 'sgpb-subs-gdpr-status', 'type' => 'checkbox', 'defaultValue' =>  '');
		$options[] = array('name' => 'sgpb-subs-gdpr-label', 'type' => 'text', 'defaultValue' =>  __('Accept Terms', SG_POPUP_TEXT_DOMAIN));
		$options[] = array('name' => 'sgpb-subs-gdpr-text', 'type' => 'text', 'defaultValue' =>  __(get_bloginfo().' will use the information you provide on this form to be in touch with you and to provide updates and marketing.', SG_POPUP_TEXT_DOMAIN));
		// proStartSilverproEndSilver
		$options[] = array('name' => 'sgpb-fblike-like-url', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-fblike-layout', 'type' => 'text', 'defaultValue' => 'standard');
		$options[] = array('name' => 'sgpb-fblike-dont-show-share-button', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-subs-fields', 'type' => 'sgpb', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-contact-fields', 'type' => 'sgpb', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-border-color', 'type' => 'text', 'defaultValue' => '#000000');
		$options[] = array('name' => 'sgpb-border-radius', 'type' => 'text', 'defaultValue' => 0);
		$options[] = array('name' => 'sgpb-show-popup-same-user', 'type' => 'checkbox', 'defaultValue' => '');
		$options[] = array('name' => 'sgpb-show-popup-same-user-count', 'type' => 'number', 'defaultValue' => 1);
		$options[] = array('name' => 'sgpb-show-popup-same-user-expiry', 'type' => 'number', 'defaultValue' => 1);
		$options[] = array('name' => 'sgpb-show-popup-same-user-page-level', 'type' => 'checkbox', 'defaultValue' => '');

		$SGPB_OPTIONS = apply_filters('sgpbPopupDefaultOptions', $options);
	}

	public static function getOldExtensionsInfo()
	{
		$data = array(
			array(
				'folderName' => 'popup-builder-ad-block',
				'label' => __('AdBlock', SG_POPUP_TEXT_DOMAIN)
			),
			array(
				'folderName' => 'popup-builder-analytics',
				'label' => __('Analytics', SG_POPUP_TEXT_DOMAIN)
			),
			array(
				'folderName' => 'popup-builder-exit-intent',
				'label' => __('Exit intent', SG_POPUP_TEXT_DOMAIN)
			),
			array(
				'folderName' => 'popup-builder-mailchimp',
				'label' => __('MailChimp', SG_POPUP_TEXT_DOMAIN)
			),
			array(
				'folderName' => 'popup-builder-aweber',
				'label' => __('AWeber', SG_POPUP_TEXT_DOMAIN)
			)
		);

		return $data;
	}

	public static function addFilters()
	{
		ConfigDataHelper::addFilters();
	}
}
