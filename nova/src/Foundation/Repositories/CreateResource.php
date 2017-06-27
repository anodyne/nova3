<?php namespace Nova\Foundation\Repositories;

trait CreateResource
{
	public function create(array $attributes = [])
	{
		return $this->model->create($attributes);
	}
}
