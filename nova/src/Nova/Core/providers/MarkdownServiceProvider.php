<?php namespace Nova\Core\Providers;

use Nova\Core\Lib\Markdown;
use dflydev\markdown\MarkdownParser;
use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['markdown'] = $this->app->share(function()
		{
			return new Markdown(new MarkdownParser);
		});
	}

}