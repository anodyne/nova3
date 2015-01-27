<?php namespace Nova\Core\Characters\Data\Interfaces;

use User;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface CharacterRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data, User $user = null);

}