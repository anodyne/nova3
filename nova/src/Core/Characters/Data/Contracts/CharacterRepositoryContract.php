<?php namespace Nova\Core\Characters\Data\Contracts;

use User;
use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface CharacterRepositoryContract extends BaseRepositoryContract {

	public function createForUser(array $data, User $user = null);

}