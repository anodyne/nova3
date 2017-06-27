<?php namespace Nova\Foundation\Repositories;

trait RestoreResource
{
	public function restore($resource)
	{
		return $this->getResource($resource)->restore();
	}
}
