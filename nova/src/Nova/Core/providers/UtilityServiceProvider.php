<?php namespace Nova\Core\Providers;

use Nova\Core\Lib\Utility;
use Nova\Core\Lib\Location;
use Nova\Core\Lib\Markdown;
use dflydev\markdown\MarkdownParser;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerLocation();
		$this->registerMarkdown();
		$this->registerUtility();
	}

	protected function registerLocation()
	{
		$this->app['location'] = $this->app->share(function()
		{
			return new Location;
		});
	}

	protected function registerMarkdown()
	{
		$this->app['markdown'] = $this->app->share(function()
		{
			return new Markdown(new MarkdownParser);
		});
	}

	protected function registerUtility()
	{
		$this->app['utility'] = $this->app->share(function()
		{
			return new Utility;
		});
	}

}