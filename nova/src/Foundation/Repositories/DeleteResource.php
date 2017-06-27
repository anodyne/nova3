<?php namespace Nova\Foundation\Repositories;

trait DeleteResource
{
	public function delete($resource)
	{
		return $this->getResource($resource)->delete();
	}

	public function forceDelete($resource)
	{
		return $this->getResource($resource)->forceDelete();
	}
}
