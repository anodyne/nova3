<?php namespace Nova\Core\Pages\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface PageContentRepositoryContract extends BaseRepositoryContract
{
	public function allExcept(array $except);
	public function find($id);
	public function getAllContent();
	public function getByKey($key, array $with = []);
	public function updateByKey(array $data);
}
