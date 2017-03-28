<?php namespace Nova\Core\Forms\Data\Contracts;

use NovaForm;
use NovaFormSection;

interface SectionRepositoryContract extends BaseFormRepositoryContract
{
	public function getBoundSections(NovaForm $form);
	public function getUnboundSections(NovaForm $form, array $relations = [], $allSections = false);
	public function reassignSectionContent(NovaFormSection $oldSection, $newSectionId);
	public function removeSectionContent(NovaFormSection $section);
}
