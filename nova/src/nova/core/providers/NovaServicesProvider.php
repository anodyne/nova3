<?php namespace Nova\Core\Providers;

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
		$this->app['nova.location'] = $this->app->share(function($app)
		{
			return new Location;
		});
	}

	protected function registerMarkdown()
	{
		$this->app['markdown'] = $this->app->share(function($app)
		{
			return new Markdown(new MarkdownParser);
		});
	}

	protected function registerSystemEvent()
	{
		$this->app['nova.event'] = $this->app->share(function($app)
		{
			return new SystemEvent;
		});
	}

	protected function registerCommon()
	{
		$this->app['nova.common'] = $this->app->share(function($app)
		{
			return new Nova;
		});
	}

	protected function registerMedia()
	{
		$this->app['nova.media'] = $this->app->share(function($app)
		{
			return new Media;
		});
	}

	protected function registerDynamicForm()
	{
		$this->app['nova.form'] = $this->app->share(function($app)
		{
			return new DynamicForm;
		});
	}

	protected function registerBrowser()
	{
		$this->app['nova.browser'] = $this->app->share(function($app)
		{
			return new Browser;
		});
	}

}