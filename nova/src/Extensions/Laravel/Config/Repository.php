<?php namespace Nova\Extensions\Laravel\Config;

use Illuminate\Config\Repository as LaravelRepository;

class Repository extends LaravelRepository {

	public function module($items)
	{
		return $this->loader->module($items);
	}

}