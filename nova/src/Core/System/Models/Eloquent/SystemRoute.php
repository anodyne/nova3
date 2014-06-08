<?php namespace Nova\Core\Models\Eloquent;

use Cache;
use Model;
use CacheInterface;

class SystemRoute extends Model implements CacheInterface {

	public $timestamps = false;

	protected $table = 'system_routes';

	protected $fillable = [
		'name', 'verb', 'uri', 'resource', 'conditions',
	];
	
	protected static $properties = [
		'id', 'verb', 'name', 'uri', 'resource', 'conditions', 'protected',
	];

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeName($query, $name, $verb = 'get')
	{
		$query->where('name', $name);

		if ($verb)
		{
			$query->where('verb', $verb);
		}
	}

	public function scopeUri($query, $uri, $verb = 'get')
	{
		$query->where('uri', $uri);
		
		if ($verb)
		{
			$query->where('verb', $verb);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Model Accessors
	|--------------------------------------------------------------------------
	*/

	public function setVerbAttribute($value)
	{
		$this->attributes['verb'] = strtolower($value);
	}

	public function setConditionsAttribute($value)
	{
		$this->attributes['conditions'] = (empty($value)) ? null : $value;
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
				'name'			=> $item->name,
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