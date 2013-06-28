<?php namespace Nova\Core\Models\Entities;

use Cache;
use Event;
use Model;
use Config;
use CacheInterface;

class SystemRoute extends Model implements CacheInterface {

	public $timestamps = false;

	protected $table = 'system_routes';

	protected $fillable = array(
		'name', 'verb', 'uri', 'resource', 'conditions',
	);
	
	protected static $properties = array(
		'id', 'verb', 'name', 'uri', 'resource', 'conditions', 'protected',
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
		$a = Config::get('app.aliases');

		Event::listen("eloquent.creating: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@beforeCreate");
		Event::listen("eloquent.created: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@afterCreate");
		Event::listen("eloquent.updating: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@beforeUpdate");
		Event::listen("eloquent.updated: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@beforeDelete");
		Event::listen("eloquent.deleted: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@afterDelete");
		Event::listen("eloquent.saving: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@beforeSave");
		Event::listen("eloquent.saved: {$a['SystemRoute']}", "{$a['SystemRouteHandler']}@afterSave");
	}

	/*
	|--------------------------------------------------------------------------
	| CacheInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Cache the items.
	 *
	 * @param	string	Name of the cache item
	 * @param	mixed	Length (in minutes) to cache; false to cache for forever
	 * @return	void
	 */
	public static function cache($name = 'nova.routes', $length = false)
	{
		// Start by flushing the cache
		static::clearCache($name);

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
				'uri'			=> $item->uri,
				'resource'		=> $item->resource,
				'conditions'	=> $item->conditions,
			];
		}

		if ($length === false)
		{
			Cache::forever($name, $routes);
		}
		else
		{
			Cache::put($name, $routes, $length);
		}
	}

	/**
	 * Clear the cache items.
	 *
	 * @param	string	Name of the cache item to remove
	 * @return	void
	 */
	public static function clearCache($name = 'nova.routes')
	{
		Cache::forget($name);
	}

}