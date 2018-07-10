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
		// Clear the cache
		cache()->forget($name);

		// Re-cache the data
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
		// Clear the cache
		cache()->forget($name);

		// Re-cache the data forever
		cache()->rememberForever($name, $callback);
	}
}
