<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;

interface SectionRepositoryInterface extends BaseFormRepositoryInterface {

	public function getBoundSections(NovaForm $form);
	public function getUnboundSections(NovaForm $form);

}
