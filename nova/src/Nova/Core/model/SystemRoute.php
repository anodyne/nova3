<?php namespace Nova\Core\Model;

use Cache;
use Event;
use Model;
use Config;

class SystemRoute extends Model {

	public $timestamps = false;

	protected $table = 'system_routes';

	protected $fillable = array(
		'name', 'verb', 'uri', 'resource',
	);
	
	protected static $properties = array(
		'id', 'verb', 'name', 'uri', 'resource', 'protected',
	);

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$classes = Config::get('app.aliases');

		Event::listen("eloquent.created: {$classes['SystemRoute']}", "{$classes['SystemRouteHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['SystemRoute']}", "{$classes['SystemRouteHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['SystemRoute']}", "{$classes['SystemRouteHandler']}@beforeDelete");
		Event::listen("eloquent.saved: {$classes['SystemRoute']}", "{$classes['SystemRouteHandler']}@afterSave");
	}

	/**
	 * Cache the routes.
	 *
	 * @return	void
	 */
	public static function cache()
	{
		// Start a new query
		$query = static::startQuery();

		// Get all the routes
		$items = $query->orderBy('protected', 'desc')->get();

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