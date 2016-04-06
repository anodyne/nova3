<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm, NovaFormTab;

interface TabRepositoryInterface extends BaseFormRepositoryInterface {

	public function countLinkIds(NovaForm $form, $linkId);
	public function getFormTabs(NovaForm $form, array $relations = [], $allTabs = false);
	public function getParentTabs(NovaForm $form, array $relations = [], $allTabs = false);
	public function listParentTabs();
	public function reassignTabContent(NovaFormTab $oldTab, $newTabId);
	public function removeTabContent(NovaFormTab $tab);

}
