<?php namespace Nova\Foundation;

trait BustsCache
{
	public function refreshCache($name, $minutes, $callback)
	{
		// Clear the cache
		cache()->forget($name);

		// Re-cache the data
		cache()->remember($name, $minutes, $callback);
	}

	public function refreshCacheForever($name, $callback)
	{
		// Clear the cache
		cache()->forget($name);

		// Re-cache the data forever
		cache()->rememberForever($name, $callback);
	}
}
