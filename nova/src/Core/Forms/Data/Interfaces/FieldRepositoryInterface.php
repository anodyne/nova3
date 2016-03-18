<?php namespace Nova\Core\Forms\Data\Interfaces;

use NovaFormField;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface FieldRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	
}
