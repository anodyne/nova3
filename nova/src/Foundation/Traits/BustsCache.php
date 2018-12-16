<?php

namespace Nova\Foundation\Traits;

trait BustsCache
{
	/**
	 * Refresh the cache for a specific set of time.
	 *
	 * @param  string  $name
	 * @param  int  $minutes
	 * @param  callback  $callback
	 * @return void
	 */
	public function refreshCache($name, $minutes, $callback)
	{
		cache()->forget($name);

		cache()->remember($name, $minutes, $callback);
	}

	/**
	 * Refresh the cache and store it forever.
	 *
	 * @param  string  $name
	 * @param  callback  $callback
	 * @return void
	 */
	public function refreshCacheForever($name, $callback)
	{
		cache()->forget($name);

		cache()->rememberForever($name, $callback);
	}
}
