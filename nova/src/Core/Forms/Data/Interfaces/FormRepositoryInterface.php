<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;

interface FormRepositoryInterface extends BaseFormRepositoryInterface {

	public function getByKey($key, array $with = []);
	public function getTabs(NovaForm $form, array $relations = []);
	public function getUnboundFields(NovaForm $form, array $relations = []);
	public function getUnboundSections(NovaForm $form, array $relations = []);
	public function getValidationRules(NovaForm $form);

}
