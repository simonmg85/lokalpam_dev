<?php
namespace sgpb;
use sgpb\PopupBuilderActivePackage;

$targetData = $popupTypeObj->getOptionValue('sgpb-conditions');
$popupTargetData = ConditionBuilder::createConditionBuilder($targetData);
$conditionsCanBeUsed = PopupBuilderActivePackage::canUseSection('popupConditionsSection');
?>

<div class="popup-conditions-wrapper popup-conditions-conditions" data-condition-type="conditions">
	<?php
	$creator = new ConditionCreator($popupTargetData);
	echo $creator->render();
	?>
</div>


<?php if (!$conditionsCanBeUsed): ?>
	<div class="sgpb-other-pro-options">
		<div class="sgpb-wrapper">
			<div class="row">
				<div class="col-md-12">
					<style type="text/css">.popup-conditions-wrapper.popup-conditions-conditions .select2-container {z-index: 0;}</style>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
