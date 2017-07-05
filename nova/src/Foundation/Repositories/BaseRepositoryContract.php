<?php namespace Nova\Foundation\Repositories;

interface BaseRepositoryContract
{
	public function all(array $with = []);
	public function create(array $data = []);
	public function delete($resource);
	public function forceDelete($resource);
	public function getModel();
	public function getResource($resource);
	public function make(array $with = []);
	public function restore($resource);
	public function update($resource, array $data);
}
