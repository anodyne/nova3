<?php namespace Nova\Core\Users\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface UserRepositoryContract extends BaseRepositoryContract {

	public function resetPassword($resource);
	
}
