<?php namespace Nova\Foundation\Data\Repositories;

abstract class BaseRepository {

	public function all(array $with = [])
	{
		return $this->make($with)->get();
	}

	public function countBy($column, $value)
	{
		$query = $this->make();

		return (int) $query->where($column, $value)->count();
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function delete($resource)
	{
		$item = $this->getResource($resource);

		if ($item)
		{
			$item->delete();

			return $item;
		}

		return false;
	}

	public function find($value, array $with = [], $column = 'id')
	{
		if ($column == 'id')
		{
			return $this->getById($value, $with);
		}

		return $this->getFirstBy($column, $value, $with);
	}

	public function forceDelete($resource)
	{
		$item = $this->getResource($resource);

		if ($item)
		{
			$item->forceDelete();

			return $item;
		}

		return false;
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

	public function getFirstBy($column, $value, array $with = [], $operator = '=')
	{
		return $this->make($with)->where($column, $operator, $value)->first();
	}

	public function getManyBy($column, $value, array $with = [], $operator = '=')
	{
		return $this->make($with)->where($column, $operator, $value)->get();
	}

	public function has($relation, array $with = [])
	{
		$entity = $this->make($with);

		return $entity->has($relation)->get();
	}

	public function listAll($value, $key)
	{
		return $this->model->pluck($value, $key)->all();
	}

	public function listAllBy($key, $value, $displayValue, $displayKey)
	{
		return $this->model->where($key, '=', $value)
			->pluck($displayValue, $displayKey)->all();
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

	public function listCollection($collection, $value, $text)
	{
		return $collection->pluck($text, $value)->all();
	}

	public function make(array $with = [])
	{
		return $this->model->with($with);
	}

	public function update($resource, array $data)
	{
		$item = $this->getResource($resource);

		if ( ! $item) return false;

		$item->fill($data)->save();

		return $item;
	}

	public function updateOrder($resource, $newOrder)
	{
		$item = $this->getResource($resource);

		if ( ! $item) return false;

		return $this->update($item, ['order' => $newOrder]);
	}

	protected function getResource($resource, $identifier = 'id')
	{
		if ($resource instanceof $this->model) return $resource;

		return $this->getFirstBy($identifier, $resource);
	}

}