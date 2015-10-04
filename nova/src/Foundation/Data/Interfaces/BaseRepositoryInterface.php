<?php namespace Nova\Foundation\Data\Interfaces;

interface BaseRepositoryInterface {

	public function all(array $with = []);
	public function countBy($key, $value, array $with = []);
	public function create(array $data);
	public function delete($resource);
	public function forceDelete($resource);
	public function getById($id, array $with = []);
	public function getByPage($page = 1, $limit = 10, array $with = []);
	public function getFirstBy($key, $value, array $with = []);
	public function getManyBy($key, $value, array $with = []);
	public function listAll($value, $key);
	public function listAllBy($key, $value, $displayValue, $displayKey);
	public function listAllFiltered($value, $key, $filters);
	public function make(array $with = []);
	public function update($resource, array $data);

}