<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm, NovaFormSection;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface SectionRepositoryInterface extends BaseRepositoryInterface {

	public function getBoundSections(NovaForm $form);
	public function getUnboundSections(NovaForm $form);

}
