<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm, NovaFormTab;

interface TabRepositoryInterface extends BaseFormRepositoryInterface {

	public function countLinkIds(NovaForm $form, $linkId);
	public function getFormTabs(NovaForm $form);
	public function getParentTabs(NovaForm $form);
	public function listParentTabs(NovaForm $form);
	public function reassignTabContent(NovaFormTab $oldTab, $newTabId);
	public function removeTabContent(NovaFormTab $tab);

}
