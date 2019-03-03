<?php
namespace sgpb;

class Filters
{
	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		add_filter('admin_url', array($this, 'addNewPostUrl'), 10, 2);
		add_filter('admin_menu', array($this, 'removeAddNewSubmenu'), 10, 2);
		add_filter('manage_'.SG_POPUP_POST_TYPE.'_posts_columns', array($this, 'popupsTableColumns'));
		add_filter('post_row_actions', array($this, 'quickRowLinksManager'), 10, 2);
		add_filter('sgpbPopupRenderOptions', array($this, 'renderOptions'), 10, 1);
		add_filter('sgpbAdminJs', array($this, 'adminJsFilter'), 1, 1);
		add_filter('sgpbAdminCssFiles', array($this, 'sgpbAdminCssFiles'), 1, 1);
		add_filter('sgpbPopupContentLoadToPage', array($this, 'filterPopupContent'), 10, 1);
		add_filter('the_content', array($this, 'clearContentPreviewMode'), 10, 1);
		add_filter('posts_where' , array($this, 'excludePostsToShow'), 10, 1);
		add_filter('preview_post_link', array($this, 'editPopupPreviewLink'), 10, 2);
		add_filter('upgrader_pre_download', array($this, 'maybeShortenEddFilename'), 10, 4);
		add_filter('sgpbSavedPostData', array($this, 'savedPostData'), 10, 1);
	}

	public function savedPostData($postData)
	{
		// for old popups here we change already saved old popup id
		if (isset($postData['sgpb-mailchimp-success-popup'])) {
			// sgpGetCorrectPopupId it's a temporary function and it will be removed in future
			if (function_exists(__NAMESPACE__.'\sgpGetCorrectPopupId')) {
				$postData['sgpb-mailchimp-success-popup'] = sgpGetCorrectPopupId($postData['sgpb-mailchimp-success-popup']);
			}
		}
		// for old popups here we change already saved old popup id
		if (isset($postData['sgpb-aweber-success-popup'])) {
			if (function_exists(__NAMESPACE__.'\sgpGetCorrectPopupId')) {
				$postData['sgpb-aweber-success-popup'] = sgpGetCorrectPopupId($postData['sgpb-aweber-success-popup']);
			}
		}

		return $postData;
	}

	public function removeAddNewSubmenu()
	{
		//we don't need the default add new, since we are using our custom page for it
		$page = remove_submenu_page(
			'edit.php?post_type='.SG_POPUP_POST_TYPE,
			'post-new.php?post_type='.SG_POPUP_POST_TYPE
		);
	}

	public function maybeShortenEddFilename($return, $package)
	{
		if (strpos($package, SG_POPUP_STORE_URL) !== false) {
			add_filter('wp_unique_filename', array($this, 'shortenEddFilename'), 100, 2);
		}
		return $return;
	}

	public function shortenEddFilename($filename, $ext)
	{
		$filename = substr($filename, 0, 20).$ext;
		remove_filter('wp_unique_filename', array($this, 'shortenEddFilename'), 10);
		return $filename;
	}

	public function editPopupPreviewLink($previewLink, $post)
	{
		if (get_option('theme_switched') === false) {
			if (!empty($post) && $post->post_type == SG_POPUP_POST_TYPE) {
				return home_url()."?popup_preview_id=".$post->ID;
			}
		}

		return $previewLink;
	}

	public function excludePostsToShow($where)
	{
		if (is_admin()) {
			if (!function_exists('get_current_screen')) {
				return $where;
			}

			$screen = get_current_screen();
			if (empty($screen)) {
				return $where;
			}

			$postType = $screen->post_type;
			if ($postType == SG_POPUP_POST_TYPE &&
				$screen instanceof \WP_Screen &&
				$screen->id === 'edit-popupbuilder') {
				$activePopupsQuery = SGPopup::getActivePopupsQueryString();
				$where .= $activePopupsQuery;
			}
		}

		return $where;
	}

	public function clearContentPreviewMode($content)
	{
		global $post_type;

		if (is_preview() && $post_type == SG_POPUP_POST_TYPE) {
			$content = '';
		}

		return $content;
	}

	public function filterPopupContent($content)
	{
		preg_match_all('/<iframe.*?src="(.*?)".*?<\/iframe>/', $content, $matches);
		/*$finalContent = '';*/
		// $matches[0] array contain iframes stings
		// $matches[1] array contain iframes URLs
		if (empty($matches) && empty($matches[0]) && empty($matches[1])) {
			return $content;
		}
		$urls = $matches[1];

		foreach ($matches[0] as $key => $iframe) {
			if (empty($urls[$key])) {
				continue;
			}

			$pos = strpos($iframe, $urls[$key]);

			if ($pos === false) {
				continue;
			}

			$content = str_replace(' src="'.$urls[$key].'"', ' src="" data-attr-src="'.esc_attr($urls[$key]).'"', $content);
		}

		return do_shortcode($content);
	}

	public function renderOptions($options = array())
	{
		if (isset($options['sgpb-button-image'])) {
			$options['sgpb-button-image'] = AdminHelper::convertImageToData($options['sgpb-button-image']);
		}

		return $options;
	}

	public function addNewPostUrl($url, $path)
	{
		if ($path == 'post-new.php?post_type='.SG_POPUP_POST_TYPE) {
			$url = str_replace('post-new.php?post_type='.SG_POPUP_POST_TYPE, 'edit.php?post_type='.SG_POPUP_POST_TYPE.'&page='.SG_POPUP_POST_TYPE, $url);
		}

		return $url;
	}

	public function popupsTableColumns($columns)
	{
		unset($columns['date']);

		$additionalItems = array();
		$additionalItems['counter'] = __('Show count', SG_POPUP_TEXT_DOMAIN);
		$additionalItems['onOff'] = __('Enabled (show popup)', SG_POPUP_TEXT_DOMAIN);
		$additionalItems['type'] = __('Type', SG_POPUP_TEXT_DOMAIN);
		$additionalItems['shortcode'] = __('Shortcode', SG_POPUP_TEXT_DOMAIN);

		return $columns + $additionalItems;
	}

	/**
	 * Function to add/hide links from popups dataTable row
	 */
	public function quickRowLinksManager($actions, $post)
	{
		global $post_type;

		if ($post_type != SG_POPUP_POST_TYPE) {
			return $actions;
		}
		// remove quick edit link
		unset($actions['inline hide-if-no-js']);
		// remove view link
		unset($actions['view']);

		$actions['clone'] = '<a href="'.$this->popupGetClonePostLink($post->ID , 'display', false).'" title="';
		$actions['clone'] .= esc_attr__("Clone this item", SG_POPUP_TEXT_DOMAIN);
		$actions['clone'] .= '">'. esc_html__('Clone', SG_POPUP_TEXT_DOMAIN).'</a>';

		return $actions;
	}

	/**
	 * Retrieve duplicate post link for post.
	 *
	 * @param int $id Optional. Post ID.
	 * @param string $context Optional, default to display. How to write the '&', defaults to '&amp;'.
	 * @return string
	 */
	public function popupGetClonePostLink($id = 0, $context = 'display')
	{
		if (!$post = get_post($id)) {
			return;
		}
		$actionName = "popupSaveAsNew";

		if ('display' == $context) {
			$action = '?action='.$actionName.'&amp;post='.$post->ID;
		} else {
			$action = '?action='.$actionName.'&post='.$post->ID;
		}

		$postTypeObject = get_post_type_object($post->post_type);

		if (!$postTypeObject) {
			return;
		}

		return wp_nonce_url(apply_filters('popupGetClonePostLink', admin_url("admin.php".$action), $post->ID, $context), 'duplicate-post_' . $post->ID);
	}

	/* media button scripts */
	public function adminJsFilter($jsFiles)
	{
		$allowToShow = MediaButton::allowToShow();
		if ($allowToShow) {
			$jsFiles['jsFiles'][] = array('folderUrl' => SG_POPUP_JS_URL, 'filename' => 'select2.min.js');
			$jsFiles['jsFiles'][] = array('folderUrl' => SG_POPUP_JS_URL, 'filename' => 'sgpbSelect2.js');
			$jsFiles['jsFiles'][] = array('folderUrl' => SG_POPUP_JS_URL, 'filename' => 'Popup.js');
			$jsFiles['jsFiles'][] = array('folderUrl' => SG_POPUP_JS_URL, 'filename' => 'PopupConfig.js');
			$jsFiles['jsFiles'][] = array('folderUrl' => SG_POPUP_JS_URL, 'filename' => 'MediaButton.js');

			$jsFiles['localizeData'][] = array(
				'handle' => 'Popup.js',
				'name' => 'sgpbPublicUrl',
				'data' => SG_POPUP_PUBLIC_URL
			);

			$jsFiles['localizeData'][] = array(
				'handle' => 'MediaButton.js',
				'name' => 'mediaButtonParams',
				'data' => array(
					'currentPostType' => get_post_type(),
					'popupBuilderPostType' => SG_POPUP_POST_TYPE
				)
			);
		}

		return $jsFiles;
	}

	/* media button styles */
	public function sgpbAdminCssFiles($cssFiles)
	{
		$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'sgbp-bootstrap.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
		$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'select2.min.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);
		$cssFiles[] = array('folderUrl' => SG_POPUP_CSS_URL, 'filename' => 'popupAdminStyles.css', 'dep' => array(), 'ver' => SG_POPUP_VERSION, 'inFooter' => false);

		return $cssFiles;
	}
}
