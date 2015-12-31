<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;

interface TabRepositoryInterface extends BaseFormRepositoryInterface {

	public function countLinkIds(NovaForm $form, $linkId);
	public function getFormTabs(NovaForm $form);
	public function getParentTabs(NovaForm $form);
	public function listParentTabs(NovaForm $form);

}
