<?php namespace Nova\Foundation\Repositories;

trait UpdateResource
{
	public function update($resource, array $attributes = [])
	{
		return $this->getResource($resource)->update($attributes);
	}
}
