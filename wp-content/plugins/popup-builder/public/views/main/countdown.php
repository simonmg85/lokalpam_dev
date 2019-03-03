<?php
	use sgpb\AdminHelper;
	$defaultData = ConfigDataHelper::defaultData();
	$popupId = $popupTypeObj->getOptionValue('sgpb-post-id');
	if (!$popupId) {
		$popupId = 0;
	}
	$params = $popupTypeObj->getCountdownParamsById($popupId, true);
	$params = AdminHelper::serializeData($params);
?>

<div class="sgpb-wrapper">
	<div class="row">
		<div class="col-md-8">
			<div class="row form-group">
				<div class="col-md-12">
					<div class="sgpb-countdown-wrapper sgpb-countdown-js-<?php echo $popupId; ?>" id="sgpb-clear-countdown" data-params='<?php echo $params; ?>'>
						<div class="sgpb-counts-content sgpb-flipclock-js-<?php echo $popupId; ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<label for="sgpb-counter-background-color" class="col-md-5 control-label">
					<?php _e('Counter background color', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<div class="sgpb-color-picker-wrapper">
						<input type="text" class="sgpb-color-picker" id="sgpb-counter-background-color" name="sgpb-counter-background-color" value="<?php echo esc_html($popupTypeObj->getOptionValue('sgpb-counter-background-color')); ?>">
					</div>
				</div>
			</div>
			<div class="row form-group">
				<label for="sgpb-counter-text-color" class="col-md-5 control-label">
					<?php _e('Counter text color', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<div class="sgpb-color-picker-wrapper">
						<input type="text" class="sgpb-color-picker" id="sgpb-counter-text-color" name="sgpb-counter-text-color" value="<?php echo esc_html($popupTypeObj->getOptionValue('sgpb-counter-text-color')); ?>">
					</div>
				</div>
			</div>
			<div class="row form-group">
				<label for="sgpb-counter-due-date" class="col-md-5 control-label">
					<?php _e('Due date', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<input type="text" id="sgpb-date-picker" class="sgpb-full-width form-control" name="sgpb-countdown-due-date" value="<?php echo esc_html($popupTypeObj->getOptionValue('sgpb-countdown-due-date')); ?>">
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-5 control-label">
					<?php _e('Countdown format', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<?php echo AdminHelper::createSelectBox($defaultData['countdownFormat'], esc_html($popupTypeObj->getOptionValue('sgpb-countdown-type')), array('name' => 'sgpb-countdown-type', 'class'=>'js-sg-select2')); ?>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-5 control-label">
					<?php _e('Timezone', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<?php echo AdminHelper::createSelectBox($defaultData['countdownTimezone'], esc_html($popupTypeObj->getOptionValue('sgpb-countdown-timezone')), array('name' => 'sgpb-countdown-timezone', 'class'=>'js-sg-select2')); ?>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-5 control-label">
					<?php _e('Select language', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<?php echo AdminHelper::createSelectBox($defaultData['countdownLanguage'], esc_html($popupTypeObj->getOptionValue('sgpb-countdown-language')), array('name' => 'sgpb-countdown-language', 'class'=>'js-sg-select2')); ?>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-5 control-label" for="sgpb-countdown-show-on-top">
					<?php _e('Show counter on the Top', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<input type="checkbox" id="sgpb-countdown-show-on-top" name="sgpb-countdown-show-on-top" <?php echo $popupTypeObj->getOptionValue('sgpb-countdown-show-on-top'); ?>>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-5 control-label" for="sgpb-countdown-close-timeout">
					<?php _e('Close popup on timeout', SG_POPUP_TEXT_DOMAIN)?>:
				</label>
				<div class="col-md-6">
					<input type="checkbox" id="sgpb-countdown-close-timeout" name="sgpb-countdown-close-timeout" <?php echo $popupTypeObj->getOptionValue('sgpb-countdown-close-timeout'); ?>>
				</div>
			</div>

			<?php
				echo AdminHelper::renderCountdownStyles($popupId, esc_html($popupTypeObj->getOptionValue('sgpb-counter-background-color')), esc_html($popupTypeObj->getOptionValue('sgpb-counter-text-color')));
			?>
		</div>
	</div>

</div>
