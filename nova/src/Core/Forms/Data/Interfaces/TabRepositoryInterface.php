<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm, NovaFormTab;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface TabRepositoryInterface extends BaseRepositoryInterface {

	public function getFormTabs(NovaForm $form);

}
