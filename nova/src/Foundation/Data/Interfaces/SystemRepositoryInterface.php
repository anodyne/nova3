<?php namespace Nova\Foundation\Data\Interfaces;

interface SystemRepositoryInterface extends BaseRepositoryInterface {

	public function createSystemRecord();
	public function generateUID($updateDb = true);
	public function getUID();
	public function getVersion();
	public function updateSystemRecord(array $data);

}