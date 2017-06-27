<?php namespace Nova\Foundation\Repositories;

abstract class BaseRepository implements BaseRepositoryContract
{
	use CreateResource, DeleteResource, RestoreResource, UpdateResource;

	protected $model;

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
}
