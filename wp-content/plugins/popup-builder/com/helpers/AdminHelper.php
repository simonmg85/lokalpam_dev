<?php
namespace sgpb;
use \DateTime;
use \DateTimeZone;
use \SgpbDataConfig;

class AdminHelper
{
	public static function buildCreatePopupUrl($popupType)
	{
		$isAvailable = $popupType->isAvailable();
		$name = $popupType->getName();

		$popupUrl = SG_POPUP_ADMIN_URL.'post-new.php?post_type='.SG_POPUP_POST_TYPE.'&sgpb_type='.$name;

		if (!$isAvailable) {
			$popupUrl = SG_POPUP_PRO_URL;
		}

		return $popupUrl;
	}

	public static function getPopupThumbClass($popupType)
	{
		$isAvailable = $popupType->isAvailable();
		$name = $popupType->getName();

		$popupTypeClassName = $name.'-popup';

		if (!$isAvailable) {
			$popupTypeClassName .= '-pro';
		}

		return $popupTypeClassName;
	}

	public static function getPopupTargetParam($param)
	{
		global $SGPB_DATA_CONFIG_ARRAY;
		$targetData = $SGPB_DATA_CONFIG_ARRAY['target'];

		if (empty($targetData[$param])) {
			return '';
		}

		return $targetData[$param];
	}

	public static function getPopupTargetParamType($param)
	{
		global $SGPB_DATA_CONFIG_ARRAY;
		$targetDataTypes = $SGPB_DATA_CONFIG_ARRAY['target']['types'];

		if (empty($targetDataTypes[$param])) {
			return '';
		}

		return $targetDataTypes[$param];
	}

	public static function createSelectBox($data, $selectedValue, $attrs)
	{
		$attrString = '';
		$selected = '';
		$selectBoxCloseTag = '</select>';

		if (!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$selectBox = '<select '.$attrString.'>';

		if (empty($data)) {
			$selectBox .= $selectBoxCloseTag;
			return $selectBox;
		}
		foreach ($data as $value => $label) {
			// When is multiSelect
			if (is_array($selectedValue)) {
				$isSelected = in_array($value, $selectedValue);
				if ($isSelected) {
					$selected = 'selected';
				}
			}
			else if ($selectedValue == $value) {
				$selected = 'selected';
			}
			else if (is_array($value) && in_array($selectedValue, $value)) {
				$selected = 'selected';
			}

			if (is_array($label)) {
				$selectBox .= '<optgroup label="'.$value.'">';
					foreach ($label as $key => $optionLabel) {
						$selected = '';
						if (is_array($selectedValue)) {
							$isSelected = in_array($key, $selectedValue);
							if ($isSelected) {
								$selected = 'selected';
							}
						}
						else if ($selectedValue == $key) {
							$selected = 'selected';
						}
						else if (is_array($key) && in_array($selectedValue, $key)) {
							$selected = 'selected';
						}

						$selectBox .= '<option value="'.$key.'" '.$selected.'>'.$optionLabel.'</option>';
					}
				$selectBox .= '</optgroup>';
			}
			else {
				$selectBox .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
			}

			$selected = '';
		}

		$selectBox .= $selectBoxCloseTag;

		return $selectBox;
	}

	public static function createInput($data, $selectedValue, $attrs)
	{
		$attrString = '';
		$savedData = $data;

		if (isset($selectedValue)) {
			$savedData = $selectedValue;
		}
		if (!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				if ($attrName == 'class') {
					$attrValue .= ' sgpb-full-width-events form-control';
				}
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}
		$input = "<input $attrString value=\"".esc_attr($savedData)."\">";

		return $input;
	}

	public static function createCheckBox($data, $selectedValue, $attrs)
	{
		$attrString = '';
		$checked = '';

		if (!empty($selectedValue)) {
			$checked = 'checked';
		}
		if (!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$input = "<input $attrString $checked>";

		return $input;
	}

	public static function createRadioButtons($elements, $name, $selectedInput, $lineMode = false)
	{
		$str = '';

		foreach ($elements as $key => $element) {;
			$value = '';
			$checked = '';

			if (isset($element['value'])) {
				$value = $element['value'];
			}
			if ($element['value'] == $selectedInput) {
				$checked = 'checked';
			}
			$attrStr = '';
			if (isset($element['data-attributes'])) {
				foreach ($element['data-attributes'] as $attrKey => $dataValue) {
					$attrStr .= $attrKey.'="'.esc_attr($dataValue).'" ';
				}
			}

			if ($lineMode) {
				$str .= '<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($value).'" '.$checked.' '.$attrStr.'>';
			}
			else {
				$str .= '<div class="row form-group">';
					$str .= '<label class="col-md-5 control-label">'.__($element['title'], SG_POPUP_TEXT_DOMAIN).'</label>';
					$str .= '<div class="col-sm-7"><input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($value).'" '.$checked.'></div>';
				$str .= '</div>';
			}
		}

		echo $str;
	}

	// countdown popup (number) styles
	public static function renderCountdownStyles($popupId = 0, $countdownBgColor, $countdownTextColor)
	{
		return  "<style type='text/css'>
			.sgpb-counts-content.sgpb-flipclock-js-$popupId.flip-clock-wrapper ul li a div div.inn {
				background-color: $countdownBgColor;
				color: $countdownTextColor;
			}
			.sgpb-countdown-wrapper {
				width: 446px;
				height: 130px;
				padding-top: 22px;
				box-sizing: border-box;
				margin: 0 auto;
			}
			.sgpb-counts-content {
				display: inline-block;
			}
			.sgpb-counts-content > ul.flip {
				width: 40px;
				margin: 4px;
			}
		</style>";
	}

	// countdown popup scripts and params
	public static function renderCountdownScript($id, $seconds, $type, $language, $timezone, $autoclose)
	{
		$params = array(
			'id'        => $id,
			'seconds'   => $seconds,
			'type'      => $type,
			'language'  => $language,
			'timezone'  => $timezone,
			'autoclose' => $autoclose
		);

		return $params;
	}

	// convert date to seconds
	public static function dateToSeconds($dueDate, $timezone)
	{
		if (empty($timezone)) {
			return '';
		}
		$timeDate = new DateTime('now', new DateTimeZone($timezone));
		$timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
		$seconds = strtotime($dueDate)-$timeNow;
		if ($seconds < 0) {
			$seconds = 0;
		}

		return $seconds;
	}

	/**
	 * Serialize data
	 *
	 * @since 1.0.0
	 *
	 * @param array $data
	 *
	 * @return string $serializedData
	 */
	public static function serializeData($data = array())
	{
		$serializedData = serialize($data);

		return $serializedData;
	}

	/**
	 * Get correct size to use it safely inside CSS rules
	 *
	 * @since 1.0.0
	 *
	 * @param string $dimension
	 *
	 * @return string $size
	 */
	public static function getCSSSafeSize($dimension)
	{
		if (empty($dimension)) {
			return 'inherit';
		}

		$size = (int)$dimension . 'px';
		// If user write dimension in px or % we give that dimension to target otherwise the default value will be px
		if (strpos($dimension, '%') || strpos($dimension, 'px')) {
			$size = $dimension;
		}

		return $size;
	}

	/**
	 * Get site protocol
	 *
	 * @since 1.0.0
	 *
	 * @return string $protocol
	 *
	 */
	public static function getSiteProtocol()
	{
		$protocol = 'http';

		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
			$protocol = 'https';
		}

		return $protocol;
	}

	public static function getCurrentUrl()
	{
		$protocol = self::getSiteProtocol();
		$currentUrl = $protocol."://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

		return $currentUrl;
	}

	public static function deleteSubscriptionPopupSubscribers($popupId)
	{
		global $wpdb;

		$prepareSql = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE subscriptionType = %s', $popupId);
		$wpdb->query($prepareSql);
	}

	public static function subscribersRelatedQuery($query = '')
	{
		global $wpdb;
		$subscribersTablename = $wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME;
		$postsTablename = $wpdb->prefix.SGPB_POSTS_TABLE_NAME;

		if ($query == '') {
			$query = 'SELECT firstName, lastName, email, cDate, '.$postsTablename.'.post_title AS subscriptionType FROM '.$subscribersTablename.' ';
		}
		$searchQuery = '';
		$filterCriteria = '';

		$query .= ' LEFT JOIN '.$postsTablename.' ON '.$postsTablename.'.ID='.$subscribersTablename.'.subscriptionType';

		if (isset($_GET['sgpb-subscription-popup-id']) && !empty($_GET['sgpb-subscription-popup-id'])) {
			$filterCriteria = esc_sql($_GET['sgpb-subscription-popup-id']);
			if ($filterCriteria != 'all') {
				$searchQuery .= "subscriptionType = $filterCriteria";
			}
		}
		if ($filterCriteria != '' && $filterCriteria != 'all' && isset($_GET['s']) && !empty($_GET['s'])) {
			$searchQuery .= ' LIKE ';
		}
		if (isset($_GET['s']) && !empty($_GET['s'])) {
			$searchCriteria = esc_sql($_GET['s']);
			$searchQuery .= " firstName LIKE '%$searchCriteria%' or lastName LIKE '%$searchCriteria%' or email LIKE '%$searchCriteria%' or $postsTablename.post_title LIKE '%$searchCriteria%'";
		}
		if (isset($_GET['sgpb-subscribers-date']) && !empty($_GET['sgpb-subscribers-date'])) {
			$filterCriteria = esc_sql($_GET['sgpb-subscribers-date']);
			if ($filterCriteria != 'all') {
				if ($searchQuery != '') {
					$searchQuery .= ' AND ';
				}
				$searchQuery .= " cDate LIKE '$filterCriteria%'";
			}
		}
		if ($searchQuery != '') {
			$query .= " WHERE ($searchQuery)";
		}

		return $query;
	}

	public static function themeRelatedSettings($popupId, $buttonPosition, $theme)
	{
		if ($popupId) {
			if ($theme == 'sgpb-theme-1' || $theme == 'sgpb-theme-4' || $theme == 'sgpb-theme-5') {
				if (isset($buttonPosition)) {
					$buttonPosition = $buttonPosition;
				}
				else {
					$buttonPosition = 'bottomRight';
				}
			}
			else if ($theme == 'sgpb-theme-2' || $theme == 'sgpb-theme-3' || $theme == 'sgpb-theme-6') {
				if (isset($buttonPosition)) {
					$buttonPosition = $buttonPosition;
				}
				else {
					$buttonPosition = 'topRight';
				}
			}
		}
		else {
			if (isset($theme)) {
				if ($theme == 'sgpb-theme-1' || $theme == 'sgpb-theme-4' || $theme == 'sgpb-theme-5') {
					$buttonPosition = 'bottomRight';
				}
				else if ($theme == 'sgpb-theme-2' || $theme == 'sgpb-theme-3' || $theme == 'sgpb-theme-6') {
					$buttonPosition = 'topRight';
				}
			}
			else {
				/* by default set position for the first theme */
				$buttonPosition = 'bottomRight';
			}
		}

		return $buttonPosition;
	}

	/**
	 * Create html attrs
	 *
	 * @since 1.0.0
	 *
	 * @param array $attrs
	 *
	 * @return string $attrStr
	 */
	public static function createAttrs($attrs)
	{
		$attrStr = '';

		if (empty($attrs)) {
			return $attrStr;
		}

		foreach ($attrs as $attrKey => $attrValue) {
			$attrStr .= $attrKey.'="'.$attrValue.'" ';
		}

		return $attrStr;
	}

	public static function getFormattedDate($date)
	{
		$date = strtotime($date);
		$month = date('F', $date);
		$year = date('Y', $date);

		return $month.' '.$year;
	}

	public static function convertImageToData($image = '')
	{
		return $image;
	}

	public static function defaultButtonImage($theme, $closeImage = '')
	{
		// if no image, set default by theme
		if ($closeImage == '') {
			if ($theme == 'sgpb-theme-1' || !$theme) {
				$closeImage = SG_POPUP_IMG_URL.'theme_1/close.png';
			}
			else if ($theme == 'sgpb-theme-2') {
				$closeImage = SG_POPUP_IMG_URL.'theme_2/close.png';
			}
			else if ($theme == 'sgpb-theme-3') {
				$closeImage = SG_POPUP_IMG_URL.'theme_3/close.png';
			}
			else if ($theme == 'sgpb-theme-5') {
				$closeImage = SG_POPUP_IMG_URL.'theme_5/close.png';
			}
			else if ($theme == 'sgpb-theme-6') {
				$closeImage = SG_POPUP_IMG_URL.'theme_6/close.png';
			}
		}

		return self::convertImageToData($closeImage);
	}

	public static function getPopupPostAllowedUserRoles()
	{
		$userSavedRoles = get_option('sgpb-user-roles');

		if (!$userSavedRoles) {
			$userSavedRoles = array('administrator');
		}
		else {
			array_push($userSavedRoles, 'administrator');
		}

		return $userSavedRoles;
	}

	public static function showMenuForCurrentUser()
	{
		$savedUserRoles = self::getPopupPostAllowedUserRoles();
		$currentUserRole = AdminHelper::getCurrentUserRole();

		return in_array($currentUserRole, $savedUserRoles);
	}

	public static function getPopupsIdAndTitle($excludesPopups = array())
	{
		$allPopups = SGPopup::getAllPopups();
		$popupIdTitles = array();

		if (empty($allPopups)) {
			return $popupIdTitles;
		}

		foreach ($allPopups as $popup) {
			if (empty($popup)) {
				continue;
			}

			$id = $popup->getId();
			$title = $popup->getTitle();
			$type = $popup->getType();

			if (!empty($excludesPopups)) {
				foreach ($excludesPopups as $excludesPopupId) {
					if ($excludesPopupId != $id) {
						$popupIdTitles[$id] = $title . ' - ' . $type;
					}
				}
			}
			else {
				$popupIdTitles[$id] = $title . ' - ' . $type;
			}
		}

		return $popupIdTitles;
	}

	/**
	 * Merge two array and merge same key values to same array
	 *
	 * @since 1.0.0
	 *
	 * @param array $array1
	 * @param array $array2
	 *
	 * @return array|bool
	 *
	 */
	public static function arrayMergeSameKeys($array1, $array2)
	{
		if (empty($array1)) {
			return array();
		}

		$modified = false;
		$array3 = array();
		foreach ($array1 as $key => $value) {
			if (isset($array2[$key]) && is_array($array2[$key])) {
				$arrDifference = array_diff($array2[$key], $array1[$key]);
				if (empty($arrDifference)) {
					continue;
				}

				$modified = true;
				$array3[$key] = array_merge($array2[$key], $array1[$key]);
				unset($array2[$key]);
				continue;
			}

			$modified = true;
			$array3[$key] = $value;
		}

		// when there are no values
		if (!$modified) {
			return $modified;
		}

		return $array2 + $array3;
	}

	public static function getCurrentUserRole()
	{
		$role = 'administrator';

		if (is_multisite()) {

			$getUsersObj = get_users(
				array(
					'blog_id' => get_current_blog_id()
				)
			);
			if (is_array($getUsersObj)) {
				foreach ($getUsersObj as $key => $userData) {
					if ($userData->ID == get_current_user_id()) {
						$roles = $userData->roles;
						if (is_array($roles) && !empty($roles)) {
							$role = $roles[0];
						}
					}
				}
			}

			return $role;
		}

		global $current_user, $wpdb;
		$userRoleKey = $wpdb->prefix . 'capabilities';
		$userRoleName = $current_user->$userRoleKey;

		if ($userRoleName) {
			$usersRoles = array_keys($userRoleName);

			if (is_array($usersRoles) && !empty($usersRoles)) {
				$role = $usersRoles[0];
			}
		}

		return $role;
	}

	public static function isAppleMobileDevice()
	{
		$isIOS = false;

		$useragent = @$_SERVER['HTTP_USER_AGENT'];
		preg_match('/iPhone|Android|iPad|iPod|webOS/', $useragent, $matches);
		$os = current($matches);
		if ($os == 'iPad' || $os == 'iPhone' || $os == 'iPod') {
			$isIOS = true;
		}

		return $isIOS;
	}

	public static function hexToRgba($color, $opacity = false)
	{
		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if (empty($color)) {
			return $default;
		}

		//Sanitize $color if "#" is provided
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
			$hex = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
		}
		else if (strlen($color) == 3) {
			$hex = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		}
		else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb = array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if ($opacity !== false) {
			if (abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = 'rgba('.implode(',', $rgb).','.$opacity.')';
		}
		else {
			$output = 'rgb('.implode(',', $rgb).')';
		}

		//Return rgb(a) color string
		return $output;
	}

	public static function getAllActiveExtensions()
	{
		$extensions = SgpbDataConfig::getOldExtensionsInfo();
		$labels = array();

		foreach ($extensions as $extension) {
			if (file_exists(WP_PLUGIN_DIR.'/'.$extension['folderName'])) {
				$labels[] = $extension['label'];
			}
		}

		return $labels;
	}

	public static function renderExtensionsContent()
	{
		$extensions = self::getAllActiveExtensions();
		ob_start();
		?>
			<p class="sgpb-extension-notice-close">x</p>
			<div class="sgpb-extensions-list-wrapper">
				<div class="sgpb-notice-header">
					<h3><?php _e('Popup Builder plugin has been successfully updated', SG_POPUP_TEXT_DOMAIN)?></h3>
					<h4><?php _e('The following extensions need to be updated manually', SG_POPUP_TEXT_DOMAIN)?></h4>
				</div>
				<ul class="sgpb-extensions-list">
					<?php foreach ($extensions as $extensionName): ?>
						<a target="_blank" href="https://popup-builder.com/forms/control-panel/"><li><?php echo $extensionName; ?></li></a>
					<?php endforeach; ?>
				</ul>
			</div>
			<p class="sgpb-extension-notice-dont-show"><?php _e('Don\'t show again')?></p>
		<?php
		$content = ob_get_contents();
		ob_get_clean();

		return $content;
	}

	public static function getReverseConvertIds()
	{
		$idsMappingSaved = get_option('sgpbConvertedIds');
		$ids = array();

		if ($idsMappingSaved) {
			$ids = $idsMappingSaved;
		}

		return array_flip($ids);
	}

	public static function getAllExtensions()
	{
		$allExtensions = SgpbDataConfig::allExtensionsKeys();

		$notActiveExtensions = array();
		$activeExtensions = array();

		foreach ($allExtensions as $extension) {
			if (!is_plugin_active($extension['pluginKey'])) {
				$notActiveExtensions[] = $extension;
			}
			else {
				$activeExtensions[] = $extension;
			}
		}

		$divideExtension = array(
			'noActive' => $notActiveExtensions,
			'active' => $activeExtensions
		);

		return $divideExtension;
	}

	public static function renderAlertProblem()
	{
		ob_start();
		?>
		<div id="welcome-panel" class="update-nag sgpb-alert-problem">
			<div class="welcome-panel-content">
				<p class="sgpb-problem-notice-close">x</p>
				<div class="sgpb-alert-problem-text-wrapper">
					<h3>Popup Builder plugin has been updated to the new version 3.</h3>
					<h5>A lot of changes and improvements have been made.</h5>
					<h5>In case of any issues, please contact us <a href="<?php echo SG_POPUP_TICKET_URL; ?>" target="_blank">here</a>.</h5>
				</div>
				<p class="sgpb-problem-notice-dont-show"><?php _e('Don\'t show again')?></p>
			</div>
		</div>
		<?php
		$content = ob_get_clean();

		return $content;
	}
}
