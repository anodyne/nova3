<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface SettingsRepositoryInterface extends BaseRepositoryInterface {

	public function findByKey($key);
	
}