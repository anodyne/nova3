<?php namespace Nova\Foundation\Providers;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
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
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return	void
	 */
	public function register()
	{
		$this->registerExtensionServiceProviders();
	}

	/**
	 * Register any service providers in the extensions.
	 *
	 * @return	void
	 */
	protected function registerExtensionServiceProviders()
	{
		// Start building the finder
		$finder = new Finder;

		/**
		 * Finder Criteria
		 *
		 * Must be a directory
		 * Must be in ./extensions
		 * Must not be the Override directory
		 * Must only be 2 levels deep (vendor and names)
		 */
		$finder->directories()
			->in(extension_path())
			->exclude('Override')
			->depth('< 2');

		// Loop through whatever we have from the finder results
		foreach ($finder as $dir) {
			// If the extension has a service provider, register it now
			if (file_exists(extension_path($dir->getRelativePathname()."/ServiceProvider.php"))) {
				$this->app->register($this->buildExtensionNamespace($dir)."\\ServiceProvider");
			}
		}
	}

	/**
	 * Build the extension namespace.
	 *
	 * @param	SplFileInfo	$info
	 * @return	string
	 */
	protected function buildExtensionNamespace(SplFileInfo $info)
	{
		return "Extensions\\".str_replace('/', '\\', $info->getRelativePathname());
	}
}
