<?php namespace Nova\Core\Providers;

use Nova\Core\Lib\Media;
use Nova\Core\Lib\Utility;
use Nova\Core\Lib\Location;
use Nova\Core\Lib\Markdown;
use Nova\Core\Lib\DynamicForm;
use Nova\Core\Lib\SystemEvent;
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
		$this->registerSystemEvent();
		$this->registerUtility();
		$this->registerMedia();
		$this->registerDynamicForm();
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

	protected function registerSystemEvent()
	{
		$this->app['nova.event'] = $this->app->share(function()
		{
			return new SystemEvent;
		});
	}

	protected function registerUtility()
	{
		$this->app['utility'] = $this->app->share(function()
		{
			return new Utility;
		});
	}

	protected function registerMedia()
	{
		$this->app['media'] = $this->app->share(function()
		{
			return new Media;
		});
	}

	protected function registerDynamicForm()
	{
		$this->app['nova.form'] = $this->app->share(function()
		{
			return new DynamicForm;
		});
	}

}