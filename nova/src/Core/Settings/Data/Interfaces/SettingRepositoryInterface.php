<?php namespace Nova\Core\Settings\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface SettingRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function getAllSettings();
	public function getByKey($key);
	public function update(array $data);
	
}
