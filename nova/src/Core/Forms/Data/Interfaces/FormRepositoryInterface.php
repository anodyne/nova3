<?php namespace Nova\Core\Forms\Data\Interfaces;

interface FormRepositoryInterface extends BaseFormRepositoryInterface {

	public function getByKey($key, array $with = []);

}
