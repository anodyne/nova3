<?php namespace Nova\Core\Providers;

use App;
use Nova\Core\Lib\Nova;
use Nova\Core\Lib\Media;
use Ikimea\Browser\Browser;
use Nova\Core\Lib\Location;
use Nova\Core\Lib\Markdown;
use Nova\Core\Lib\DynamicForm;
use Nova\Core\Lib\SystemEvent;
use dflydev\markdown\MarkdownParser;
use Illuminate\Support\ServiceProvider;

class NovaServicesProvider extends ServiceProvider {

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
		$this->registerCommon();
		$this->registerMedia();
		$this->registerDynamicForm();
		$this->registerBrowser();
	}

	protected function registerLocation()
	{
		$this->app->singleton('nova.location', function()
		{
			return new Location;
		});
	}

	protected function registerMarkdown()
	{
		$this->app->singleton('markdown', function()
		{
			return new Markdown(new MarkdownParser);
		});
	}

	protected function registerSystemEvent()
	{
		$this->app->singleton('nova.event', function()
		{
			return new SystemEvent;
		});
	}

	protected function registerCommon()
	{
		$this->app->singleton('nova.common', function()
		{
			return new Nova;
		});
	}

	protected function registerMedia()
	{
		$this->app->singleton('nova.media', function()
		{
			return new Media;
		});
	}

	protected function registerDynamicForm()
	{
		$this->app->singleton('nova.form', function()
		{
			return new DynamicForm;
		});
	}

	protected function registerBrowser()
	{
		$this->app->singleton('nova.browser', function()
		{
			return new Browser;
		});
	}

}