<?php namespace Nova\Core\Pages\Data\Interfaces;

use Illuminate\Routing\Route;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface PageContentRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function delete($id);
	
}
