<?php namespace Nova\Foundation\Data\Contracts;

interface SystemRepositoryContract extends BaseRepositoryContract {

	public function createSystemRecord();
	public function generateUID($updateDb = true);
	public function getUID();
	public function getVersion();
	public function updateSystemRecord(array $data);

}