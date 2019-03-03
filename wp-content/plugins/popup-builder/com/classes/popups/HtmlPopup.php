<?php
namespace sgpb;
require_once(dirname(__FILE__).'/SGPopup.php') ;
class HtmlPopup extends SGPopup {

	public function __construct() {
		add_filter('sgpbFrontendJsFiles', array($this, 'popupFrontJsFilter'),1,1);
		add_filter('sgpbAdminJsFiles', array($this, 'popupAdminJsFilter'),1,1);
	}

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

	public function getPopupTypeMainView()
	{
		return array();
	}

	public function getPopupTypeContent()
	{
		$htmlContent = '';
		$popupContent = $this->getContent();

		$htmlContent .= '<div class="sgpb-main-html-content-wrapper">';
		$htmlContent .= $popupContent;
		$htmlContent .= '</div>';
		return $htmlContent;
	}

	public function getExtraRenderOptions()
	{
		return array();
	}
}
