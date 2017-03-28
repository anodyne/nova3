<?php namespace Nova\Core\Forms\Data\Contracts;

use NovaFormField;
use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface FieldRepositoryContract extends BaseRepositoryContract
{
	public function create(array $data);
}
