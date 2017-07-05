<?php namespace Nova\Foundation\Repositories;

abstract class BaseRepository implements BaseRepositoryContract
{
	protected $model;

	public function all(array $with = [])
	{
		return $this->make($with)->get();
	}

	public function create(array $data = [])
	{
		return $this->model->create($data);
	}

	public function delete($resource)
	{
		return $this->getResource($resource)->delete();
	}

	public function forceDelete($resource)
	{
		return $this->getResource($resource)->forceDelete();
	}

	public function getModel()
	{
		return $this->model;
	}

	public function getResource($resource)
	{
		if ($resource instanceof $this->model) {
			return $resource;
		}

		return $this->model->where('id', $resource)->first();
	}

	public function make(array $with = [])
	{
		return $this->model->with($with);
	}

	public function restore($resource)
	{
		return $this->getResource($resource)->restore();
	}

	public function update($resource, array $data = [])
	{
		$resource = $this->getResource($resource);

		$resource->update($data);

		return $resource->fresh();
	}
}
