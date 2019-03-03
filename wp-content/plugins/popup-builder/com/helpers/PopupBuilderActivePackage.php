<?php
namespace sgpb;

class PopupBuilderActivePackage
{
	// sections and additional options array
	private static $sections = array();

	public static function init()
	{
		self::$sections = array(
			'userStatus' => array('min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER),
			'popupConditionsSection' => array('min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER),
			'popupOtherConditionsSection' => array('min-version' => SGPB_POPUP_PRO_MIN_VERSION, 'min-pkg' => SGPB_POPUP_PKG_SILVER)
		);
	}

	public static function canUseSection($optionName)
	{
		if (!isset(self::$sections[$optionName])) {
			return false;
		}

		return self::checkVersionAndPackage(self::$sections[$optionName]);
	}

	public static function canUseOption($optionName)
	{
		global $SGPB_OPTIONS;

		foreach ($SGPB_OPTIONS as $option) {
			if ($option['name'] == $optionName) {
				$currentOption = $option;
			}
		}

		return self::checkVersionAndPackage($currentOption);
	}

	private static function checkVersionAndPackage($option)
	{
		$currentOptionSupportedMinVersion = '';
		$currentOptionSupportedMinPackage = '';

		if (isset($option['min-version'])) {
			$currentOptionSupportedMinVersion = $option['min-version'];
		}
		if (isset($option['min-pkg'])) {
			$currentOptionSupportedMinPackage = $option['min-pkg'];
		}

		if ($currentOptionSupportedMinVersion <= SG_POPUP_VERSION) {
			if ($currentOptionSupportedMinPackage <= SGPB_POPUP_PKG) {
				return true;
			}
		}

		return false;
	}
}

PopupBuilderActivePackage::init();
