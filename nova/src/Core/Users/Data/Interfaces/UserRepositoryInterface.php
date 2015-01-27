<?php namespace Nova\Core\Users\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);

}