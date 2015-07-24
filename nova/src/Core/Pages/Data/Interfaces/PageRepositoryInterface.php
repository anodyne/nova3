<?php namespace Nova\Core\Pages\Data\Interfaces;

use Illuminate\Routing\Route;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface PageRepositoryInterface extends BaseRepositoryInterface {

	public function all($verb = false);
	public function create(array $data);
	public function delete($id);
	public function find($id);
	public function getByRouteKey($route);
	public function getByRouteUri($route);
	public function update($id, array $data);

}