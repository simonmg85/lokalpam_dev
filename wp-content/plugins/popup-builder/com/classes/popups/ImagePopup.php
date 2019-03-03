<?php
namespace sgpb;
require_once(dirname(__FILE__).'/SGPopup.php');

class ImagePopup extends SGPopup
{
	public function popupFrontJsFilter($jsFiles)
	{
		return $jsFiles;
	}

	public function popupAdminJsFilter($jsFiles)
	{
		return $jsFiles;
	}

	public function getOptionValue($optionName, $forceDefaultValue = false)
	{
		return parent::getOptionValue($optionName, $forceDefaultValue);
	}

	public function getPopupTypeOptionsView()
	{
		return array();
	}

	public function getRemoveOptions()
	{
		// Where 1 mean this options must not show for this popup type
		$removeOptions = array(
			'sgpb-reopen-after-form-submission' => 1
		);

		return $removeOptions;
	}

	public function getPopupTypeMainView()
	{
		return array(
			'filePath' => SG_POPUP_TYPE_MAIN_PATH.'image.php',
			'metaboxTitle' => 'Image Popup Main Options'
		);
	}

	/**
	 * It returns what the current post supports (for example: title, editor, etc...)
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function getPopupTypeSupports()
	{
		return array('title');
	}

	public function getPopupTypeContent()
	{
		$imageContent = '';
		$popupOptions = $this->getOptions();

		$image = $popupOptions['sgpb-image-url'];
		$maxWidth = $popupOptions['sgpb-max-width'];
		$maxHeight = $popupOptions['sgpb-max-height'];

		$styles = '';

		if ($maxWidth) {
			$styles .= 'max-width: '.$maxWidth.'px;';
		}
		if ($maxHeight) {
			$styles .= 'max-height: '.$maxHeight.'px;';
		}
		if ($styles) {
			$styles = ' style="'.$styles.'"';
		}

		$imageContent .= '<div class="sgpb-main-image-content-wrapper">';
		$imageContent .= '<img src="'.esc_attr($image).'"'.$styles.'>';
		$imageContent .= '</div>';

		return $imageContent;
	}

	public function getExtraRenderOptions()
	{
		return array();
	}
}
