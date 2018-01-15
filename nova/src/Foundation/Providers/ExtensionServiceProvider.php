<?php namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class ExtensionServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return	void
	 */
	public function boot()
	{
		if ($this->app['nova']->isInstalled()) {
			// Grab the list of active extensions from the cache
			$extensions = cache('nova.extensions', ['Anodyne/ThemeKit']);

			foreach ($extensions as $path) {
				// If the extension has a service provider, register it now
				if (file_exists(extension_path("{$path}/ServiceProvider.php"))) {
					$this->app->register($this->buildExtensionNamespace($path)."\\ServiceProvider");
				}
			}
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return	void
	 */
	public function register()
	{
		//
	}

	/**
	 * Build the extension namespace.
	 *
	 * @param	string	$path
	 * @return	string
	 */
	protected function buildExtensionNamespace($path)
	{
		return "Extensions\\".str_replace('/', '\\', $path);
	}
}
