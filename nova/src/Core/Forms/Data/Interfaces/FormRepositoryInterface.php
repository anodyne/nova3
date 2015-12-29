<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaForm;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface FormRepositoryInterface extends BaseRepositoryInterface {

	public function find($id);
	public function findByKey($key, array $with = []);

}
