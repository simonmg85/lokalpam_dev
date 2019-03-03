<?php
namespace sgpb;
use \WP_Query;
use \SgpbPopupConfig;
use \SgpbDataConfig;

class Actions
{
	public $customPostTypeObj;

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		add_action('init', array($this, 'postTypeInit'), 9999);
		add_action('admin_menu', array($this, 'addSubMenu'));
		add_filter('get_sample_permalink_html', array($this, 'removePostPermalink'), 1, 1);
		add_action('manage_'.SG_POPUP_POST_TYPE.'_posts_custom_column' , array($this, 'popupsTableColumnsValues'), 10, 2);
		add_action('media_buttons', array($this, 'popupMediaButton'));
		add_action('admin_enqueue_scripts', array('sgpb\Style', 'enqueueStyles'));
		add_action('admin_enqueue_scripts', array('sgpb\Javascript', 'enqueueScripts'));
		add_action('add_meta_boxes', array($this, 'popupTargetMetaBox'));
		add_action('add_meta_boxes', array($this, 'popupEventsMetaBox'));
		add_action('add_meta_boxes', array($this, 'popupConditions'));
		add_action('add_meta_boxes', array($this, 'popupBehaviorAfterSpecialEvents'));
		add_action('add_meta_boxes', array($this, 'popupDesign'));
		add_action('add_meta_boxes', array($this, 'popupCloseSettings'));
		add_action('add_meta_boxes', array($this, 'popupDimensionSettings'));
		add_action('add_meta_boxes', array($this, 'popupOptionsMetaBox'));
		add_action('add_meta_boxes', array($this, 'popupOtherConditions'));
		// this action for popup options saving and popup builder classes save ex from post and page
		add_action('save_post', array($this, 'savePost'), 100, 3);
		add_action('wp_enqueue_scripts', array($this, 'enqueuePopupBuilderScripts'));
		add_action('admin_enqueue_scripts', array($this, 'adminLoadPopups'));
		add_action('admin_action_popupSaveAsNew', array($this, 'popupSaveAsNew'));
		add_action('dp_duplicate_post', array($this, 'popupCopyPostMetaInfo'), 10, 2);
		add_filter('sgpbOtherConditions', array($this ,'conditionsSatisfy'));
		add_filter(SG_POPUP_CATEGORY_TAXONOMY.'_row_actions' , array($this, 'taxonomyRowActions'), 2, 2);
		add_filter('post_updated_messages', array($this, 'popupPublishedMessage'), 1, 1);
		add_action('admin_post_csv_file', array($this, 'getSubscribersCsvFile'));
		add_action('before_delete_post', array($this, 'deleteSubscribersWithPopup'), 1, 1);
		add_shortcode('sg_popup', array($this, 'popupShortcode'));
		add_filter('cron_schedules', array($this, 'cronAddMinutes'), 10, 1);
		add_action('sgpb_send_newsletter', array($this, 'newsletterSendEmail'), 10, 1);
		add_action('admin_post_sgpbSaveSettings', array($this, 'saveSettings'), 10, 1);
		add_action('admin_init', array($this, 'disableAutosave'));
		add_action('admin_init', array($this, 'userRolesCaps'));
		add_action('admin_head', array($this, 'showPreviewButtonAfterPopupPublish'));
		add_action('admin_notices', array($this, 'pluginNotices'));
		add_action('admin_notices', array($this, 'promotionalBanner'), 10);
		add_action('init', array($this, 'pluginLoaded'));
		add_filter('wp_insert_post_data', array($this, 'editPublishSettings'), 100, 1);
		// for change admin popup list order
		add_action('pre_get_posts', array($this, 'preGetPosts'));
		new Ajax();
	}

	public function editPublishSettings($post)
	{
		if (isset($post['post_type']) && $post['post_type'] == SG_POPUP_POST_TYPE) {
			// force set status to publish
			if (isset($post['post_status']) && ($post['post_status'] == 'draft' || $post['post_status'] == 'pending')) {
				$post['post_status'] = 'publish';
			}
		}

		return $post;
	}

	public function preGetPosts($query)
	{
		if (!is_admin() || !isset($_GET['post_type']) || $_GET['post_type'] != SG_POPUP_POST_TYPE) {
			return false;
		}

		// change default order by id and desc
		if (!isset($_GET['orderby'])) {
			$query->set('orderby', 'ID');
			$query->set('order', 'desc');
		}

		return true;
	}

	public function promotionalBanner()
	{
		global $post_type;

		if (!get_option('SGPB_PROMOTIONAL_BANNER_CLOSED') && $post_type == SG_POPUP_POST_TYPE) {
			require_once(SG_POPUP_VIEWS_PATH.'mainRateUsBanner.php');
		}
	}

	public function pluginNotices()
	{
		$extensions =  AdminHelper::getAllActiveExtensions();
		$updated = get_option('sgpb_extensions_updated');

		$content = '';

		// if popup builder has the old version
		if (!get_option('SG_POPUP_VERSION')) {
			return $content;
		}

		$alertProblem = get_option('sgpb_alert_problems');
		// for old users show alert about problems
		if (!$alertProblem) {
			echo AdminHelper::renderAlertProblem();
		}

		// Don't show the banner if there's not any extension of Popup Builder or if the user has clicked "don't show"
		if (empty($extensions) || $updated) {
			return $content;
		}
		ob_start();
		?>
		<div id="welcome-panel" class="update-nag sgpb-extensions-notices">
			<div class="welcome-panel-content">
				<?php echo AdminHelper::renderExtensionsContent(); ?>
			</div>
		</div>
		<?php
		$content = ob_get_clean();

		echo $content;
		return true;
	}

	public function pluginLoaded()
	{
		$versionPopup = get_option('SG_POPUP_VERSION');
		$convert = get_option('sgpbConvertToNewVersion');

		if ($versionPopup && !$convert) {
			update_option('sgpbConvertToNewVersion', 1);
			ConvertToNewVersion::convert();
			Installer::registerPlugin();
		}
	}

	public function showPreviewButtonAfterPopupPublish()
	{
		if (!empty($_GET['post_type']) && $_GET['post_type'] == SG_POPUP_POST_TYPE && !isset($_GET['post'])) {
			echo '<style>
				#post-preview,#save-post {
					display:none !important;
				}
			</style>';
		}
	}

	public function popupMediaButton()
	{
		echo new MediaButton();
	}

	public function userRolesCaps()
	{
		$userSavedRoles = get_option('sgpb-user-roles');

		if (!$userSavedRoles) {
			$userSavedRoles = array('administrator');
		}
		else {
			array_push($userSavedRoles, 'administrator');
		}

		foreach ($userSavedRoles as $theRole) {
			$role = get_role($theRole);

			$role->add_cap('read');
			$role->add_cap('read_post');
			$role->add_cap('read_private_sgpb_popups');
			$role->add_cap('edit_sgpb_popup');
			$role->add_cap('edit_sgpb_popups');
			$role->add_cap('edit_others_sgpb_popups');
			$role->add_cap('edit_published_sgpb_popups');
			$role->add_cap('publish_sgpb_popups');
			$role->add_cap('delete_sgpb_popups');
			$role->add_cap('delete_published_posts');
			$role->add_cap('delete_others_sgpb_popups');
			$role->add_cap('delete_private_sgpb_popups');
			$role->add_cap('delete_private_sgpb_popup');
			$role->add_cap('delete_published_sgpb_popups');

			// For popup builder sub-menus and terms
			$role->add_cap('sgpb_manage_options');
			$role->add_cap('manage_popup_terms');
			$role->add_cap('manage_popup_categories_terms');
		}

		return true;
	}

	public function disableAutosave()
	{
		if (!empty($_GET['post_type']) && $_GET['post_type'] == SG_POPUP_POST_TYPE) {
			wp_deregister_script('autosave');
		}
	}

	public function popupShortcode($args, $content)
	{
		if (empty($args) || empty($args['id'])) {
			return $content;
		}

		$oldShortcode = isset($args['event']) && $args['event'] === 'onload';
		$isInherit = isset($args['event']) && $args['event'] == 'inherit';
		$event = '';

		$shortcodeContent = '';
		$argsId = $popupId = (int)$args['id'];

		// for old popups
		if (function_exists('sgpb\sgpGetCorrectPopupId')) {
			$popupId = sgpGetCorrectPopupId($popupId);
		}

		$popup = SGPopup::find($popupId);

		$event = preg_replace('/on/', '', @$args['event']);
		// when popup does not exists or popup post status it's not publish ex when popup in trash
		if (empty($popup) || (!is_object($popup) && $popup != 'publish')) {
			return $content;
		}
		$alreadySavedEvents = $popup->getEvents();
		$loadableMode = $popup->getLoadableModes();

		if (!isset($args['event']) && isset($args['insidepopup'])) {
			unset($args['insidepopup']);
			$event = 'insideclick';
		}
		// if no event attribute is set, or old shortcode
		if (!isset($args['event']) || $oldShortcode || $isInherit) {
			$loadableMode = $popup->getLoadableModes();
			if (!empty($content)) {
				$alreadySavedEvents = false;
			}
			// for old popup, after the update, there aren't any events
			if (empty($alreadySavedEvents)) {
				$event = '';
				if (!empty($content)) {
					$event = 'click';
				}
				if (!empty($args['event'])) {
					$event = $args['event'];
				}
				$event = preg_replace('/on/', '', $event);
				$popup->setEvents(array($event));
			}
			if (empty($loadableMode)) {
				$loadableMode = array();
			}
			$loadableMode['option_event'] = true;
		}
		else {
			$event = $args['event'];
			$event = preg_replace('/on/', '', $event);
			$popup->setEvents(array($event));
		}

		$popup->setLoadableModes($loadableMode);
		$scriptsLoader = new ScriptsLoader();
		$loadablePopups = array($popup);
		$groupObj = new PopupGroupFilter();
		$groupObj->setPopups(array($popup));
		$loadablePopups = $groupObj->filter();
		$scriptsLoader->setLoadablePopups($loadablePopups);
		$scriptsLoader->loadToFooter();

		if (!empty($content)) {
			$matches = SGPopup::getPopupShortcodeMatchesFromContent($content);
			if (!empty($matches)) {
				foreach ($matches[0] as $key => $value) {
					$attrs = shortcode_parse_atts($matches[3][$key]);
					if (empty($attrs['id'])) {
						continue;
					}
					$shortcodeContent = SGPopup::renderPopupContentShortcode($content, $attrs['id'], $attrs['event'], $attrs);
					break;
				}
			}
		}

		if (isset($event) && $event != 'onload' && !empty($content)) {
			$shortcodeContent = SGPopup::renderPopupContentShortcode($content, $argsId, $event, $args);
		}

		return do_shortcode($shortcodeContent);
	}

	public function deleteSubscribersWithPopup($postId)
	{
		global $post_type;

		if ($post_type == SG_POPUP_POST_TYPE) {
			AdminHelper::deleteSubscriptionPopupSubscribers($postId);
		}
	}

	public function cronAddMinutes($schedules)
	{
		$schedules['sgpb_newsletter_send_every_minute'] = array(
			'interval' => SGPB_CRON_REPEAT_INTERVAL * 60,
			'display' => __('Once Every Minute', SG_POPUP_TEXT_DOMAIN)
		);

		return $schedules;
	}

	public function newsletterSendEmail()
	{
		global $wpdb;
		$newsletterOptions = get_option('SGPB_NEWSLETTER_DATA');

		if (empty($newsletterOptions)) {
			wp_clear_scheduled_hook('sgpb_send_newsletter');
		}
		$subscriptionFormId = (int)$newsletterOptions['subscriptionFormId'];
		$subscriptionFormTitle = get_the_title($subscriptionFormId);
		$emailsInFlow = (int)$newsletterOptions['emailsInFlow'];
		$mailSubject = $newsletterOptions['newsletterSubject'];
		$fromEmail = $newsletterOptions['fromEmail'];
		$emailMessage = $newsletterOptions['messageBody'];

		// When email is not valid we don't continue
		if (!preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/', $fromEmail)) {
			wp_clear_scheduled_hook('sgpb_send_newsletter');
			return false;
		}
		$sql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE status = 0 and subscriptionType = %d limit 1', $subscriptionFormId);
		$result = $wpdb->get_row($sql, ARRAY_A);
		$currentStateEmailId = (int)$result['id'];
		$getTotalSql = $wpdb->prepare('SELECT count(*) FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE subscriptionType = %d', $subscriptionFormId);
		$totalSubscribers = $wpdb->get_var($getTotalSql);

		// $currentStateEmailId == 0 when all emails status = 1
		if ($currentStateEmailId == 0) {
			// Clear schedule hook
			$headers  = 'MIME-Version: 1.0'."\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
			$successTotal = get_option('SGPB_NEWSLETTER_'.$subscriptionFormId);
			if (!$successTotal) {
				$successTotal = 0;
			}
			$failedTotal = $totalSubscribers - $successTotal;

			$emailMessageCustom = 'Your mail list '.$subscriptionFormTitle.' delivered successfully!
						'.$successTotal.' of the '.$totalSubscribers.' emails succeeded, '.$failedTotal.' failed.
						For more details, please download log file inside the plugin.

						This email was generated via Popup Builder plugin.';

			wp_mail($fromEmail, $subscriptionFormTitle.' list has been successfully delivered!', $emailMessageCustom, $headers);
			delete_option('SGPB_NEWSLETTER_'.$subscriptionFormId);
			wp_clear_scheduled_hook('sgpb_send_newsletter');
			return;
		}
		$getAllDataSql = $wpdb->prepare('SELECT firstName, lastName, email FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE id >= %d and subscriptionType = %s limit %d', $currentStateEmailId, $subscriptionFormId, $emailsInFlow);
		$subscribers = $wpdb->get_results($getAllDataSql, ARRAY_A);

		$blogInfo = get_bloginfo();
		$headers = array(
			'From: "'.$blogInfo.'" <'.$fromEmail.'>' ,
			'MIME-Version: 1.0' ,
			'Content-type: text/html; charset=iso-8859-1'
		);

		foreach ($subscribers as $subscriber) {
			$patternFirstName = '/\[First name]/';
			$patternLastName = '/\[Last name]/';
			$patternBlogName = '/\[Blog name]/';
			$patternUserName = '/\[User name]/';

			$replacementFirstName = $subscriber['firstName'];
			$replacementLastName = $subscriber['lastName'];
			$replacementBlogName = $newsletterOptions['blogname'];
			$replacementUserName = $newsletterOptions['username'];

			// Replace First name and Last name from email message
			$emailMessageCustom = preg_replace($patternFirstName, $replacementFirstName, $emailMessage);
			$emailMessageCustom = preg_replace($patternLastName, $replacementLastName, $emailMessageCustom);
			$emailMessageCustom = preg_replace($patternBlogName, $replacementBlogName, $emailMessageCustom);
			$emailMessageCustom = preg_replace($patternUserName, $replacementUserName, $emailMessageCustom);
			$emailMessageCustom = stripslashes($emailMessageCustom);
			$mailStatus = wp_mail($subscriber['email'], $mailSubject, $emailMessageCustom, $headers);

			if (!$mailStatus) {
				$errorLogSql = $wpdb->prepare('INSERT INTO '. $wpdb->prefix .SGPB_SUBSCRIBERS_ERROR_TABLE_NAME.' (`popupType`, `email`, `date`) VALUES (%s, %s, %s)', $subscriptionFormId, $subscriber['email'], date('Y-m-d H:i'));
				$wpdb->query($errorLogSql);
				continue;
			}

			$successCount = get_option('SGPB_NEWSLETTER_'.$subscriptionFormId);
			if (!$successCount) {
				update_option('SGPB_NEWSLETTER_'.$subscriptionFormId, 1);
			}
			else {
				update_option('SGPB_NEWSLETTER_'.$subscriptionFormId, ++$successCount);
			}
		}

		// Update the status of all the sent mails
		$updateStatusQuery = $wpdb->prepare('UPDATE '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' SET status = 1 where id >= %d and subscriptionType = %d limit %d', $currentStateEmailId, $subscriptionFormId, $emailsInFlow);
		$wpdb->query($updateStatusQuery);
	}

	public function taxonomyRowActions($actions, $row)
	{
		if ($row->slug == SG_RANDOM_TAXONOMY_SLUG) {
			return array();
		}

		return $actions;
	}

	public function enqueuePopupBuilderScripts()
	{
		// for old popups
		if (get_option('SG_POPUP_VERSION')) {
			ConvertToNewVersion::saveCustomInserted();
		}

		PopupLoader::instance()->loadPopups();
	}

	public function adminLoadPopups($hook)
	{
		$allowedPages = array();
		$allowedPages = apply_filters('sgpbAdminLoadedPages', $allowedPages);

		if (!empty($allowedPages) && is_array($allowedPages) && in_array($hook, $allowedPages)) {
			$scriptsLoader = new ScriptsLoader();
			$scriptsLoader->setIsAdmin(true);
			$scriptsLoader->loadToFooter();
		}
	}

	public function postTypeInit()
	{
		if (isset($_POST['sgpb-is-preview']) && $_POST['sgpb-is-preview'] == 1) {
			$postId = $_POST['post_ID'];
			$post = get_post($postId);
			$this->savePost($postId, $post, false);
		}

		if (isset($_GET['page']) && $_GET['page'] == 'PopupBuilder') {
			echo '<span>Popup Builder plugin has been successfully updated. Please <a href="'.admin_url().'edit.php?post_type='.SG_POPUP_POST_TYPE.'">click here</a> to go to the new Dashboard of the plugin.</span>';
			wp_die();
		}
		$this->customPostTypeObj = new RegisterPostType();
	}

	public function addSubMenu()
	{
		$this->customPostTypeObj->addSubMenu();
	}

	public function popupTargetMetaBox()
	{
		$this->customPostTypeObj->addTargetMetaBox();
	}

	public function popupEventsMetaBox()
	{
		$this->customPostTypeObj->addEventMetaBox();
	}

	public function popupConditions()
	{
		$this->customPostTypeObj->addConditionsMetaBox();
	}

	public function popupBehaviorAfterSpecialEvents()
	{
		$this->customPostTypeObj->addBehaviorAfterSpecialEventsMetaBox();
	}

	public function popupDesign()
	{
		$this->customPostTypeObj->popupDesignMetaBox();
	}

	public function popupCloseSettings()
	{
		$this->customPostTypeObj->addCloseSettingsMetaBox();
	}

	public function popupDimensionSettings()
	{
		$this->customPostTypeObj->addDimensionsSettingsMetaBox();
	}

	public function popupOptionsMetaBox()
	{
		$this->customPostTypeObj->addOptionsMetaBox();
	}

	public function popupOtherConditions()
	{
		$this->customPostTypeObj->addOtherConditions();
	}

	public function savePost($postId = 0, $post = array(), $update = false)
	{
		$postData = SGPopup::parsePopupDataFromData($_POST);
		$saveMode = '';
		$postData['sgpb-post-id'] = $postId;
		// If preview mode
		if (isset($postData['sgpb-is-preview']) && $postData['sgpb-is-preview'] == 1) {
			$saveMode = '_preview';
			SgpbPopupConfig::popupTypesInit();
			SgpbDataConfig::init();
			// published popup
			if (empty($post)) {
				global $post;
				$postId = $post->ID;
			}
			if ($post->post_status != 'draft') {
				$posts = array();
				$popupContent = $post->post_content;

				$query = new WP_Query(
					array(
						'post_parent'    => $postId,
						'posts_per_page' => - 1,
						'post_type'      => 'revision',
						'post_status'    => 'inherit'
					)
				);
				while ($query->have_posts()) {
					$query->the_post();
					if (empty($posts)) {
						$posts[] = $post;
					}
				}
				if (!empty($posts[0])) {
					$popup = $posts[0];
					$popupContent = $popup->post_content;
				}
			}
		}

		if (!$update && !$saveMode) {
			return;
		}

		if (empty($post)) {
			$saveMode = '';
		}
		/* In preview mode saveMode should be true*/
		if ((!empty($post) && $post->post_type == SG_POPUP_POST_TYPE) || $saveMode || (empty($post) && !$saveMode)) {
			if (!empty($postData['sgpb-type'])) {
				$popupType = $postData['sgpb-type'];
				$popupClassName = SGPopup::getPopupClassNameFormType($popupType);
				$popupClassPath = SGPopup::getPopupTypeClassPath($popupType);
				require_once($popupClassPath.$popupClassName.'.php');
				$popupClassName = __NAMESPACE__.'\\'.$popupClassName;

				$popupClassName::create($postData, $saveMode, 1);
			}
		}
		else {
			$content = get_post_field('post_content', $postId);
			SGPopup::deletePostCustomInsertedData($postId);
			SGPopup::deletePostCustomInsertedEvents($postId);
			/*We detect all the popups that were inserted as a custom ones, in the content.*/
			SGPopup::savePopupsFromContentClasses($content, $post);
		}
	}

	/**
	 * Check Popup is satisfy for popup condition
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return bool
	 *
	 */
	public function conditionsSatisfy($args)
	{
		return PopupChecker::checkOtherConditionsActions($args);
	}

	public function popupsTableColumnsValues($column, $postId)
	{
		$postId = (int)$postId;// Convert to int for security reasons
		$switchButton = '';
		$isActive = '';
		global $post_type;
		if ($postId) {
			$args['status'] = array('publish', 'draft', 'pending', 'private', 'trash');
			$popup = SGPopup::find($postId, $args);
		}

		if (empty($popup) && $post_type == SG_POPUP_POST_TYPE) {
			return false;
		}

		if ($column == 'shortcode') {
			echo '<input type="text" onfocus="this.select();" readonly value="[sg_popup id='.$postId.']" class="large-text code">';
		}
		else if ($column == 'counter') {
			$count = $popup->getPopupOpeningCountById($postId);
			echo $count;
		}
		else if ($column == 'type') {
			global $SGPB_POPUP_TYPES;
			$type = $popup->getType();
			if (isset($SGPB_POPUP_TYPES['typeLabels'][$type])) {
				$type = $SGPB_POPUP_TYPES['typeLabels'][$type];
			}
			echo $type;
		}
		else if ($column == 'onOff') {
			$popupPostStatus = get_post_status($postId);
			if ($popupPostStatus == 'publish' || $popupPostStatus == 'draft') {
				$isActive = $popup->getOptionValue('sgpb-is-active', true);
			}
			$switchButton .= '<label class="sgpb-switch">';
			$switchButton .= '<input class="sg-switch-checkbox" data-switch-id="'.$postId.'" type="checkbox" '.$isActive.'>';
			$switchButton .= '<div class="sgpb-slider sgpb-round"></div>';
			$switchButton .= '</label>';
			echo $switchButton;
		}
	}

	/*
	 * This function calls the creation of a new copy of the selected post (by default preserving the original publish status)
	 * then redirects to the post list
	 */
	public function popupSaveAsNew($status = '')
	{
		if (!(isset($_GET['post']) || isset($_POST['post']) || (isset($_REQUEST['action']) && 'popupSaveAsNew' == $_REQUEST['action']))) {
			wp_die(esc_html__('No post to duplicate has been supplied!', SG_POPUP_TEXT_DOMAIN));
		}
		// Get the original post
		$id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);

		check_admin_referer('duplicate-post_'.$id);

		$post = get_post($id);

		// Copy the post and insert it
		if (isset($post) && $post != null) {
			$newId = $this->popupCreateDuplicate($post, $status);
			$postType = $post->post_type;

			if ($status == '') {
				$sendBack = wp_get_referer();
				if (!$sendBack ||
					strpos($sendBack, 'post.php') !== false ||
					strpos($sendBack, 'post-new.php') !== false) {
					if ('attachment' == $postType) {
						$sendBack = admin_url('upload.php');
					}
					else {
						$sendBack = admin_url('edit.php');
						if (!empty($postType)) {
							$sendBack = add_query_arg('post_type', $postType, $sendBack);
						}
					}
				}
				else {
					$sendBack = remove_query_arg(array('trashed', 'untrashed', 'deleted', 'cloned', 'ids'), $sendBack);
				}
				// Redirect to the post list screen
				wp_redirect(add_query_arg(array('cloned' => 1, 'ids' => $post->ID), $sendBack));
			}
			else {
				// Redirect to the edit screen for the new draft post
				wp_redirect(add_query_arg(array('cloned' => 1, 'ids' => $post->ID), admin_url('post.php?action=edit&post='.$newId)));
			}
			exit;

		}
		else {
			wp_die(esc_html__('Copy creation failed, could not find original:', SG_POPUP_TEXT_DOMAIN).' '.htmlspecialchars($id));
		}
	}

	/**
	 * Create a duplicate from a post
	 */
	public function popupCreateDuplicate($post, $status = '', $parent_id = '')
	{
		$newPostStatus = (empty($status))? $post->post_status: $status;

		if ($post->post_type != 'attachment') {
			$title = $post->post_title;
			if ($title == '') {
				// empty title
				$title = __('(no title) (clone)');
			}
			else {
				$title .= ' '.__('(clone)');
			}

			if ('publish' == $newPostStatus || 'future' == $newPostStatus) {
				// check if the user has the right capability
				if (is_post_type_hierarchical($post->post_type)) {
					if (!current_user_can('publish_pages')) {
						$newPostStatus = 'pending';
					}
				}
				else {
					if (!current_user_can('publish_posts')) {
						$newPostStatus = 'pending';
					}
				}
			}
		}

		$newPostAuthor = wp_get_current_user();
		$newPostAuthorId = $newPostAuthor->ID;
		// check if the user has the right capability
		if (is_post_type_hierarchical($post->post_type)) {
			if (current_user_can('edit_others_pages')) {
				$newPostAuthorId = $post->post_author;
			}
		}
		else {
			if (current_user_can('edit_others_posts')) {
				$newPostAuthorId = $post->post_author;
			}
		}

		$newPost = array(
			'menu_order'            => $post->menu_order,
			'comment_status'        => $post->comment_status,
			'ping_status'           => $post->ping_status,
			'post_author'           => $newPostAuthorId,
			'post_content'          => $post->post_content,
			'post_content_filtered' => $post->post_content_filtered,
			'post_excerpt'          => $post->post_excerpt,
			'post_mime_type'        => $post->post_mime_type,
			'post_parent'           => $newPostParent = empty($parent_id)? $post->post_parent : $parent_id,
			'post_password'         => $post->post_password,
			'post_status'           => $newPostStatus,
			'post_title'            => $title,
			'post_type'             => $post->post_type,
		);

		$newPost['post_date'] = $newPostDate = $post->post_date;
		$newPost['post_date_gmt'] = get_gmt_from_date($newPostDate);
		$newPostId = wp_insert_post(wp_slash($newPost));

		// If the copy is published or scheduled, we have to set a proper slug.
		if ($newPostStatus == 'publish' || $newPostStatus == 'future') {
			$postName = $post->post_name;
			$postName = wp_unique_post_slug($postName, $newPostId, $newPostStatus, $post->post_type, $newPostParent);

			$newPost = array();
			$newPost['ID'] = $newPostId;
			$newPost['post_name'] = $postName;

			// Update the post into the database
			wp_update_post(wp_slash($newPost));
		}

		// If you have written a plugin which uses non-WP database tables to save
		// information about a post you can hook this action to dupe that data.
		if ($post->post_type == 'page' || is_post_type_hierarchical($post->post_type)) {
			do_action('dp_duplicate_page', $newPostId, $post, $status);
		}
		else {
			do_action('dp_duplicate_post', $newPostId, $post, $status);
		}

		delete_post_meta($newPostId, '_sgpb_original');
		add_post_meta($newPostId, '_sgpb_original', $post->ID);

		return $newPostId;
	}

	/**
	 * Copy the meta information of a post to another post
	 */
	public function popupCopyPostMetaInfo($newId, $post)
	{
		$postMetaKeys = get_post_custom_keys($post->ID);
		$metaBlacklist = '';

		if (empty($postMetaKeys) || !is_array($postMetaKeys)) {
			return;
		}
		$metaBlacklist = explode(',', $metaBlacklist);
		$metaBlacklist = array_filter($metaBlacklist);
		$metaBlacklist = array_map('trim', $metaBlacklist);
		$metaBlacklist[] = '_edit_lock';
		$metaBlacklist[] = '_edit_last';
		$metaBlacklist[] = '_wp_page_template';
		$metaBlacklist[] = '_thumbnail_id';

		$metaBlacklist = apply_filters('duplicate_post_blacklist_filter' , $metaBlacklist);

		$metaBlacklistString = '('.implode(')|(',$metaBlacklist).')';
		$metaKeys = array();

		if (strpos($metaBlacklistString, '*') !== false) {
			$metaBlacklistString = str_replace(array('*'), array('[a-zA-Z0-9_]*'), $metaBlacklistString);

			foreach ($postMetaKeys as $metaKey) {
				if (!preg_match('#^'.$metaBlacklistString.'$#', $metaKey)) {
					$metaKeys[] = $metaKey;
				}
			}
		}
		else {
			$metaKeys = array_diff($postMetaKeys, $metaBlacklist);
		}

		$metaKeys = apply_filters('duplicate_post_meta_keys_filter', $metaKeys);

		foreach ($metaKeys as $metaKey) {
			$metaValues = get_post_custom_values($metaKey, $post->ID);
			foreach ($metaValues as $metaValue) {
				$metaValue = maybe_unserialize($metaValue);
				add_post_meta($newId, $metaKey, $this->popupWpSlash($metaValue));
			}
		}
	}

	public function popupAddSlashesDeep($value)
	{
		if (function_exists('map_deep')) {
			return map_deep($value, array($this, 'popupAddSlashesToStringsOnly'));
		}
		else {
			return wp_slash($value);
		}
	}

	public function popupAddSlashesToStringsOnly($value)
	{
		return is_string($value) ? addslashes($value) : $value;
	}

	public function popupWpSlash($value)
	{
		return $this->popupAddSlashesDeep($value);
	}

	public function removePostPermalink($args)
	{
		global $post_type;

		if ($post_type == SG_POPUP_POST_TYPE && is_admin()) {
			// hide permalink for popupbuilder post type
			return '';
		}

		return $args;
	}

	// remove link ( e.g.: (View post) ), from popup updated/published message
	public function popupPublishedMessage($messages)
	{
		global $post_type;

		if ($post_type == SG_POPUP_POST_TYPE) {
			// post(popup) updated
			if (isset($messages['post'][1])) {
				$messages['post'][1] = __('Post updated.', SG_POPUP_TEXT_DOMAIN);
			}
			// post(popup) published
			if (isset($messages['post'][6])) {
				$messages['post'][6] = __('Post published.', SG_POPUP_TEXT_DOMAIN);
			}
		}

		return $messages;
	}

	public function getSubscribersCsvFile()
	{
		global $wpdb;

		$query = AdminHelper::subscribersRelatedQuery();
		if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
			if (isset($_GET['order']) && !empty($_GET['order'])) {
				$query .= ' ORDER BY '.esc_sql($_GET['orderby']).' '.esc_sql($_GET['order']);
			}
		}
		$content = '';
		$exportTypeQuery = '';
		$rows = array('first name', 'last name', 'email', 'date', 'popup');
		foreach ($rows as $value) {
			$content .= $value;
			if ($value != 'popup') {
				$content .= ',';
			}
		}
		$content .= "\n";
		$subscribers = $wpdb->get_results($query, ARRAY_A);
		foreach($subscribers as $values) {
			foreach ($values as $key => $value) {
				$content .= $value;
				if ($key != 'subscriptionType') {
					$content .= ',';
				}
			}
			$content .= "\n";
		}

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=subscribersList.csv;');
		header('Content-Transfer-Encoding: binary');
		echo $content;
	}

	public function saveSettings()
	{
		$postData = $_POST;
		$deleteData = 0;

		if (isset($postData['sgpb-dont-delete-data'])) {
			$deleteData = 1;
		}
		$userRoles = @$postData['sgpb-user-roles'];

		update_option('sgpb-user-roles', $userRoles);
		update_option('sgpb-dont-delete-data', $deleteData);

		wp_redirect(admin_url().'edit.php?post_type='.SG_POPUP_POST_TYPE.'&page='.SG_POPUP_SETTINGS_PAGE);
	}
}
