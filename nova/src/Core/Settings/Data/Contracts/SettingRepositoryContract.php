<?php namespace Nova\Core\Settings\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface SettingRepositoryContract extends BaseRepositoryContract {

	public function create(array $data);
	public function getAllSettings();
	public function getByKey($key);
	public function updateByKey(array $data);
	
}
