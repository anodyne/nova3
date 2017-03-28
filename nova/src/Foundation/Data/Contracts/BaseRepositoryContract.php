<?php namespace Nova\Foundation\Data\Contracts;

interface BaseRepositoryContract
{
	public function all(array $with = []);
	public function countBy($column, $value);
	public function create(array $data);
	public function delete($resource);
	public function forceDelete($resource);
	public function getById($id, array $with = []);
	public function getByPage($page = 1, $perPage = 10, array $with = [], $sort = false, $items = false);
	public function getFirstBy($column, $value, array $with = [], $operator = '=');
	public function getManyBy($column, $value, array $with = [], $operator = '=');
	public function getModel();
	public function listAll($value, $key);
	public function listAllBy($key, $value, $displayValue, $displayKey);
	public function listAllFiltered($value, $key, $filters);
	public function listCollection($collection, $value, $text);
	public function make(array $with = []);
	public function paginate($data, $page, $perPage, $path);
	public function transform($transformer, $resource, array $parameters = []);
	public function transformAll($transformer, $resource, array $parameters = []);
	public function update($resource, array $data);
	public function updateOrder($resource, $newOrder);
}
