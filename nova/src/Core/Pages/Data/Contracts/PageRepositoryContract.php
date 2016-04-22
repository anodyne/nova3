<?php namespace Nova\Core\Pages\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface PageRepositoryContract extends BaseRepositoryContract {

	public function all(array $with = [], $verb = false);
	public function find($id);
	public function getByRouteKey($route, $with = []);
	public function getByRouteUri($route, $with = []);

}