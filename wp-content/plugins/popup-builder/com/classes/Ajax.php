<?php
namespace sgpb;
use \ConfigDataHelper;

class Ajax
{
	private $postData;

	public function __construct()
	{
		$this->actions();
	}

	public function setPostData($postData)
	{
		$this->postData = $postData;
	}

	public function getPostData()
	{
		return $this->postData;
	}

	/**
	 * Return ajax param form post data by key
	 *
	 * @since 1.0.0
	 *
	 * @param string $key
	 *
	 * @return string $value
	 */
	public function getValueFromPost($key)
	{
		$postData = $this->getPostData();
		$value = '';

		if (!empty($postData[$key])) {
			$value = $postData[$key];
		}

		return $value;
	}

	public function actions()
	{
		add_action('wp_ajax_add_condition_group_row', array($this, 'addConditionGroupRow'));
		add_action('wp_ajax_add_condition_rule_row', array($this, 'addConditionRuleRow'));
		add_action('wp_ajax_change_condition_rule_row', array($this, 'changeConditionRuleRow'));
		add_action('wp_ajax_select2_search_data', array($this, 'select2SearchData'));
		add_action('wp_ajax_sgpb_subscription_submission', array($this, 'subscriptionSubmission'));
		add_action('wp_ajax_nopriv_sgpb_subscription_submission', array($this, 'subscriptionSubmission'));
		add_action('wp_ajax_change_popup_status', array($this, 'changePopupStatus'));
		// proStartGoldproEndGold
		add_action('wp_ajax_sgpb_subscribers_delete', array($this, 'deleteSubscribers'));
		add_action('wp_ajax_sgpb_add_subscribers', array($this, 'addSubscribers'));
		add_action('wp_ajax_sgpb_send_newsletter', array($this, 'sendNewsletter'));
		add_action('wp_ajax_sgpb_send_to_open_counter', array($this, 'addToCounter'));
		add_action('wp_ajax_nopriv_sgpb_send_to_open_counter', array($this, 'addToCounter'));
		add_action('wp_ajax_sgpb_send_to_open_counter', array($this, 'addToCounter'));
		add_action('wp_ajax_sgpb_close_banner', array($this, 'closeMainRateUsBanner'));
		/*Extension notification panel*/
		add_action('wp_ajax_sgpb_dont_show_extension_panel', array($this, 'extensionNotificationPanel'));
		add_action('wp_ajax_sgpb_dont_show_problem_alert', array($this, 'dontShowProblemAlert'));
	}

	public function dontShowProblemAlert()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce');
		update_option('sgpb_alert_problems', 1);
		echo SGPB_AJAX_STATUS_TRUE;
		wp_die();
	}

	public function extensionNotificationPanel()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce');
		update_option('sgpb_extensions_updated', 1);
		echo SGPB_AJAX_STATUS_TRUE;
		wp_die();
	}

	public function closeMainRateUsBanner()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce');
		update_option('SGPB_PROMOTIONAL_BANNER_CLOSED', 'SGPB_PROMOTIONAL_BANNER_CLOSED');
		wp_die();
	}

	public function addToCounter()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce');

		$popupParams = $_POST['params'];
		$popupId = (int)$popupParams['popupId'];
		$popupsCounterData = get_option('SgpbCounter');

		if ($popupsCounterData === false) {
			$popupsCounterData = array();
		}

		if (empty($popupsCounterData[$popupId])) {
			$popupsCounterData[$popupId] = 0;
		}
		$popupsCounterData[$popupId] += 1;

		update_option('SgpbCounter', $popupsCounterData);
		wp_die();
	}

	public function deleteSubscribers()
	{
		global $wpdb;

		check_ajax_referer(SG_AJAX_NONCE, 'nonce');

		$subscribersId = array_map('sanitize_text_field', $_POST['subscribersId']);

		foreach ($subscribersId as $subscriberId) {
			$prepareSql = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE id = %d', $subscriberId);
			$wpdb->query($prepareSql);
		}
	}

	public function addSubscribers()
	{
		global $wpdb;

		check_ajax_referer(SG_AJAX_NONCE, 'nonce');
		$status = SGPB_AJAX_STATUS_FALSE;
		$firstName = sanitize_text_field($_POST['firstName']);
		$lastName = sanitize_text_field($_POST['lastName']);
		$email = sanitize_text_field($_POST['email']);
		$date = date('Y-m-d');
		$subscriptionPopupsId = array_map('sanitize_text_field', $_POST['popups']);

		foreach ($subscriptionPopupsId as $subscriptionPopupId) {
			$selectSql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE email = %s AND subscriptionType = %d', $email, $subscriptionPopupId);
			$res = $wpdb->get_row($selectSql, ARRAY_A);
			// add new subscriber
			if (empty($res)) {
				$sql = $wpdb->prepare('INSERT INTO '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' (firstName, lastName, email, cDate, subscriptionType) VALUES (%s, %s, %s, %s, %d) ', $firstName, $lastName, $email, $date, $subscriptionPopupId);
				$res = $wpdb->query($sql);
			}
			// edit existing
			else {
				$sql = $wpdb->prepare('UPDATE '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' SET firstName = %s, lastName = %s, email = %s, cDate = %s, subscriptionType = %d WHERE id = %d', $firstName, $lastName, $email, $date, $subscriptionPopupId, $res['id']);
				$wpdb->query($sql);
				$res = 1;
			}

			if ($res) {
				$status = SGPB_AJAX_STATUS_TRUE;
			}
		}

		echo $status;
		wp_die();
	}

	public function sendNewsletter()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce');
		global $wpdb;

		$newsletterData = stripslashes_deep($_POST['newsletterData']);
		$subscriptionFormId = (int)$newsletterData['subscriptionFormId'];

		$updateStatusQuery = $wpdb->prepare('UPDATE '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' SET status = 0 WHERE subscriptionType = %d', $subscriptionFormId);
		$wpdb->query($updateStatusQuery);
		$newsletterData['blogname'] = get_bloginfo('name');
		$newsletterData['username'] = wp_get_current_user()->user_login;
		update_option('SGPB_NEWSLETTER_DATA', $newsletterData);

		wp_schedule_event(time(), 'sgpb_newsletter_send_every_minute', 'sgpb_send_newsletter');
		wp_die();
	}

	// proStartGoldproEndGold

	public function changePopupStatus()
	{
		$popupId = (int)$_POST['popupId'];
		$obj = SGPopup::find($popupId);
		if (!$obj) {
			wp_die(SGPB_AJAX_STATUS_FALSE);
		}
		$options = $obj->getOptions();
		$options['sgpb-is-active'] = sanitize_text_field($_POST['popupStatus']);

		unset($options['sgpb-conditions']);
		update_post_meta($popupId, 'sg_popup_options', $options);

		wp_die($popupId);
	}

	public function subscriptionSubmission()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce');
		$this->setPostData($_POST);
		$submissionData = $this->getValueFromPost('formData');
		$popupPostId = (int)$this->getValueFromPost('popupPostId');

		parse_str($submissionData, $formData);

		if (empty($formData)) {
			echo SGPB_AJAX_STATUS_FALSE;
			wp_die();
		}

		$hiddenChecker = sanitize_text_field($formData['sgpb-subs-hidden-checker']);

		// this check is made to protect ourselves from bot
		if (!empty($hiddenChecker)) {
			echo 'Bot';
			wp_die();
		}
		global $wpdb;

		$status = SGPB_AJAX_STATUS_FALSE;
		$date = date('Y-m-d');
		$email = sanitize_email($formData['sgpb-subs-email']);
		$firstName = sanitize_text_field($formData['sgpb-subs-first-name']);
		$lastName = sanitize_text_field($formData['sgpb-subs-last-name']);

		$subscribersTableName = $wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME;

		$getSubscriberQuery = $wpdb->prepare('SELECT id FROM '.$subscribersTableName.' WHERE email = %s AND subscriptionType = %d', $email, $popupPostId);
		$list = $wpdb->get_row($getSubscriberQuery, ARRAY_A);

		// When subscriber does not exist we insert to subscribers table otherwise we update user info
		if (empty($list['id'])) {
			$sql = $wpdb->prepare('INSERT INTO '.$subscribersTableName.' (firstName, lastName, email, cDate, subscriptionType) VALUES (%s, %s, %s, %s, %d) ', $firstName, $lastName, $email, $date, $popupPostId);
			$res = $wpdb->query($sql);
		}
		else {
			$sql = $wpdb->prepare('UPDATE '.$subscribersTableName.' SET firstName = %s, lastName = %s, email = %s, cDate = %s, subscriptionType = %d WHERE id = %d', $firstName, $lastName, $email, $date, $popupPostId, $list['id']);
			$wpdb->query($sql);
			$res = 1;
		}

		if ($res) {
			$status = SGPB_AJAX_STATUS_TRUE;
		}

		echo $status;
		wp_die();
	}

	public function select2SearchData()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce_ajax');

		$postTypeName = sanitize_text_field($_POST['searchKey']);
		$search = sanitize_text_field($_POST['searchTerm']);

		$args      = array(
			's'              => $search,
			'post__in'       => ! empty( $_REQUEST['include'] ) ? array_map( 'intval', $_REQUEST['include'] ) : null,
			'page'           => ! empty( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : null,
			'posts_per_page' => 10,
			'post_type'      => $postTypeName
		);
		$searchResults = ConfigDataHelper::getPostTypeData($args);

		if (empty($searchResults)) {
			$results['items'] = array();
		}

		/*Selected custom post type convert for select2 format*/
		foreach ($searchResults as $id => $name) {
			$results['items'][] = array(
				'id'   => $id,
				'text' => $name
			);
		}

		echo json_encode($results);
		wp_die();
	}

	public function addConditionGroupRow()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce_ajax');
		global $SGPB_DATA_CONFIG_ARRAY;

		$groupId = (int)$_POST['groupId'];
		$targetType = sanitize_text_field($_POST['conditionName']);
		$addedObj = array();

		$builderObj = new ConditionBuilder();

		$builderObj->setGroupId($groupId);
		$builderObj->setRuleId(SG_CONDITION_FIRST_RULE);
		$builderObj->setSavedData($SGPB_DATA_CONFIG_ARRAY[$targetType]['initialData'][0]);
		$builderObj->setConditionName($targetType);
		$addedObj[] = $builderObj;

		$creator = new ConditionCreator($addedObj);
		echo $creator->render();
		wp_die();
	}

	public function addConditionRuleRow()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce_ajax');
		$data = '';
		global $SGPB_DATA_CONFIG_ARRAY;
		$targetType = sanitize_text_field($_POST['conditionName']);
		$builderObj = new ConditionBuilder();

		$groupId = (int)$_POST['groupId'];
		$ruleId = (int)$_POST['ruleId'];

		$builderObj->setGroupId($groupId);
		$builderObj->setRuleId($ruleId);
		$builderObj->setSavedData($SGPB_DATA_CONFIG_ARRAY[$targetType]['initialData'][0]);
		$builderObj->setConditionName($targetType);

		$data .= ConditionCreator::createConditionRuleRow($builderObj);

		echo $data;
		wp_die();
	}

	public function changeConditionRuleRow()
	{
		check_ajax_referer(SG_AJAX_NONCE, 'nonce_ajax');
		$data = '';
		global $SGPB_DATA_CONFIG_ARRAY;

		$targetType = sanitize_text_field($_POST['conditionName']);
		$builderObj = new ConditionBuilder();
		$conditionConfig = $SGPB_DATA_CONFIG_ARRAY[$targetType];
		$groupId = (int)$_POST['groupId'];
		$ruleId = (int)$_POST['ruleId'];
		$paramName = sanitize_text_field($_POST['paramName']);

		$savedData = array(
			'param' => 	$paramName
		);

		if ($targetType == 'target' || $targetType == 'conditions') {
			$savedData['operator'] = '==';
		}
		else if ($targetType == 'behavior-after-special-events') {
			$savedData['operator'] = $paramName;
		}

		$savedData['value'] = @$conditionConfig['paramsData'][$paramName];
		$savedData['hiddenOption'] = @$conditionConfig['hiddenOptionData'][$paramName];

		$builderObj->setGroupId($groupId);
		$builderObj->setRuleId($ruleId);
		$builderObj->setSavedData($savedData);
		$builderObj->setConditionName($targetType);

		$data .= ConditionCreator::createConditionRuleRow($builderObj);

		echo $data;
		wp_die();
	}
}
