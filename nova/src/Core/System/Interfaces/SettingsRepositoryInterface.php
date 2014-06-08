<?php namespace Nova\Core\System\Interfaces;

use BaseRepositoryInterface;

interface SettingsRepositoryInterface extends BaseRepositoryInterface {

	public function findByKey($key);
	
}