<?php
namespace sgpb;
class ConditionBuilder
{
	private $savedData = array();
	private $groupId;
	private $ruleId;
	private $conditionName;
	private $groupTotal;
	private $takeValueFrom = 'param';

	public function setSavedData($savedData)
	{
		$this->savedData = $savedData;
	}

	public function getSavedData()
	{
		return $this->savedData;
	}

	public function setGroupTotal($groupTotal)
	{
		$this->groupTotal = $groupTotal;
	}

	public function getGroupTotal()
	{
		return $this->groupTotal;
	}

	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	public function getGroupId()
	{
		return $this->groupId;
	}

	public function setRuleId($ruleId)
	{
		$this->ruleId = $ruleId;
	}

	public function getRuleId()
	{
		return $this->ruleId;
	}

	public function setTakeValueFrom($takeValueFrom)
	{
		$this->takeValueFrom = $takeValueFrom;
	}

	public function getTakeValueFrom()
	{
		return $this->takeValueFrom;
	}

	public function setConditionName($conditionName)
	{
		$this->conditionName = $conditionName;
	}

	public function getConditionName()
	{
		return $this->conditionName;
	}

	public static function createTargetConditionBuilder($conditionData = array())
	{
		$targetColumns = array();

		if(empty($conditionData)) {
			return $targetColumns;
		}

		foreach($conditionData as $groupId => $groupData) {

			if(empty($groupData)) {
				continue;
			}

			foreach($groupData as $ruleId => $ruleData) {
				$builderObj = new ConditionBuilder();
				$builderObj->setGroupId($groupId);
				$builderObj->setRuleId($ruleId);
				/*Assoc array where key option name value saved Data*/
				$builderObj->setSavedData($ruleData);
				$builderObj->setConditionName('target');
				$builderObj->setGroupTotal(sizeof($groupData) - 1);
				$targetColumns[] = $builderObj;
			}
		}

		return $targetColumns;
	}

	public static function createEventsConditionBuilder($conditionData)
	{
		$eventsDataObj = array();

		if(empty($conditionData)) {
			return $eventsDataObj;
		}

		foreach($conditionData as $groupId => $groupData) {

			if(empty($groupData)) {
				continue;
			}

			foreach($groupData as $ruleId => $ruleData) {
				$builderObj = new ConditionBuilder();
				$builderObj->setGroupId($groupId);
				$builderObj->setRuleId($ruleId);
				/*Assoc array where key option name value saved Data*/
				$builderObj->setSavedData($ruleData);
				$builderObj->setConditionName('events');

				$builderObj->setGroupTotal(sizeof($groupData) - 1);
				$eventsDataObj[] = $builderObj;
			}
		}

		return $eventsDataObj;
	}

	public static function createConditionBuilder($conditionData)
	{
		$eventsDataObj = array();

		if(empty($conditionData)) {
			return $eventsDataObj;
		}

		foreach($conditionData as $groupId => $groupData) {

			if(empty($groupData)) {
				continue;
			}

			foreach($groupData as $ruleId => $ruleData) {
				$builderObj = new ConditionBuilder();
				$builderObj->setGroupId($groupId);
				$builderObj->setRuleId($ruleId);
				/*Assoc array where key option name value saved Data*/
				$builderObj->setSavedData($ruleData);
				$builderObj->setConditionName('conditions');

				$builderObj->setGroupTotal(sizeof($groupData) - 1);
				$eventsDataObj[] = $builderObj;
			}
		}

		return $eventsDataObj;
	}

	public static function createBehaviorAfterSpecialEventsConditionBuilder($data)
	{
		$dataObj = array();

		if (empty($data)) {
			return $dataObj;
		}

		foreach ($data as $groupId => $groupData) {
			if (empty($groupData)) {
				continue;
			}

			foreach ($groupData as $ruleId => $ruleData) {
				$builderObj = new ConditionBuilder();
				$builderObj->setGroupId($groupId);
				$builderObj->setRuleId($ruleId);
				$builderObj->setSavedData($ruleData);
				$builderObj->setConditionName('behavior-after-special-events');
				$builderObj->setGroupTotal(count($groupData) - 1);
				$builderObj->setTakeValueFrom('operator');
				$dataObj[] = $builderObj;
			}
		}

		return $dataObj;
	}
}
