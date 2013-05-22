<?php namespace Nova\Core\Model;

use Cache;
use Model;

class SystemRoute extends Model {

	public $timestamps = false;

	protected $table = 'system_routes';

	protected $fillable = array(
		'name', 'verb', 'uri', 'resource',
	);
	
	protected static $properties = array(
		'id', 'verb', 'name', 'uri', 'resource', 'protected',
	);

	/**
	 * Cache the routes.
	 *
	 * @return	void
	 */
	public static function cache()
	{
		// Get all the routes
		$items = static::all();

		// Start the routes array
		$routes = [
			'get'		=> [],
			'put'		=> [],
			'post'		=> [],
			'delete'	=> [],
		];

		foreach ($items as $item)
		{
			$routes[$item->verb][$item->name] = [
				'uri'		=> $item->uri,
				'resource'	=> $item->resource,
			];
		}

		// Remove the cache
		Cache::forget('nova.routes');

		// Cache the routes
		Cache::forever('nova.routes', $routes);
	}

}