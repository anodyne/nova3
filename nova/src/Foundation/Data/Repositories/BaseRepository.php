<?php namespace Nova\Foundation\Data\Repositories;

abstract class BaseRepository {

	public function all()
	{
		return $this->model->all();
	}

	public function countBy($key, $value, array $with = [])
	{
		$query = $this->make($with);

		return $query->where($key, $value)->count();
	}

	public function getById($id, array $with = [])
	{
		$query = $this->make($with);

		return $query->find($id);
	}

	public function getByPage($page = 1, $limit = 10, array $with = [])
	{
		// Start building the result set
		$result = new stdClass;
		$result->page = $page;
		$result->limit = $limit;
		$result->totalItems = 0;
		$result->items = [];

		// Start building the query
		$query = $this->make($with);

		$model = $query->skip($limit * ($page - 1))
			->take($limit)
			->get();

		// Fill in the result set
		$result->totalItems = $this->model->count();
		$result->items = $modal->all();

		return $result;
	}

	public function getFirstBy($key, $value, array $with = [])
	{
		return $this->make($with)->where($key, '=', $value)->first();
	}

	public function getManyBy($key, $value, array $with = [])
	{
		return $this->make($with)->where($key, '=', $value)->get();
	}

	public function has($relation, array $with = [])
	{
		$entity = $this->make($with);

		return $entity->has($relation)->get();
	}

	public function listAll($value, $key)
	{
		return $this->model->lists($value, $key)->all();
	}

	public function listAllBy($key, $value, $displayValue, $displayKey)
	{
		return $this->model->where($key, '=', $value)
			->lists($displayValue, $displayKey)->all();
	}

	public function listAllFiltered($value, $key, $filters)
	{
		// Get the list of all the items
		$items = $this->listAll($value, $key);

		// Make sure we have an array of filters
		$filters = ( ! is_array($filters)) ? [$filters] : $filters;

		foreach ($filters as $filter)
		{
			unset($items[$filter]);
		}

		return $items;
	}

	public function make(array $with = [])
	{
		return $this->model->with($with);
	}

}