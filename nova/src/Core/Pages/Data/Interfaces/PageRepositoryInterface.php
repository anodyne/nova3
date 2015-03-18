<?php namespace Nova\Core\Pages\Data\Interfaces;

use Illuminate\Routing\Route;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface PageRepositoryInterface extends BaseRepositoryInterface {

	public function all();
	public function countRouteKeys($key);
	public function create(array $data);
	public function find($id);
	public function getByRouteKey(Route $route);
	public function getByRouteUri(Route $route);

}