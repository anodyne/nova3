<?php namespace Nova\Foundation\Data\Contracts;

interface SystemRepositoryContract extends BaseRepositoryContract {

	public function createSystemRecord();
	public function generateUUID($updateDb = true);
	public function getAllInfo();
	public function getUUID();
	public function getVersion();
	public function setVersionNumber($version);
	public function updateSystemRecord(array $data);

}