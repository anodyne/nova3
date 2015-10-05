<?php namespace Nova\Core\Pages\Data\Interfaces;

use Illuminate\Routing\Route;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface PageContentRepositoryInterface extends BaseRepositoryInterface {

	public function allExcept(array $except);
	public function find($id);
	public function getAllContent();
	public function getByKey($key, array $with = []);
	public function updateByKey(array $data);
	
}
