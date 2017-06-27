<?php namespace Nova\Foundation\Repositories;

interface BaseRepositoryContract
{
	public function create(array $attributes = []);
	public function delete($resource);
	public function forceDelete($resource);
	public function restore($resource);
	public function update($resource, array $attributes);

	public function getModel();
	public function getResource($resource);
	public function make(array $with = []);
}
