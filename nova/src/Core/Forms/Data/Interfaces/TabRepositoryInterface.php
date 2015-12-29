<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm, NovaFormTab;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface TabRepositoryInterface extends BaseRepositoryInterface {

	public function countLinkIds(NovaForm $form, $linkId);
	public function find($id);
	public function getForm(NovaFormTab $tab);
	public function getFormTabs(NovaForm $form);
	public function getParentTabs(NovaForm $form);
	public function listParentTabs(NovaForm $form);

}
