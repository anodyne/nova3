<?php namespace Nova\Extensions\Laravel\Config;

use Illuminate\Config\LoaderInterface as LaravelLoaderInterface;

interface LoaderInterface extends LaravelLoaderInterface {

	public function module($items);

}