<?php namespace Nova\Foundation\Bootstrap;

use Symfony\Component\Finder\Finder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as IlluminateLoadConfig;

class LoadConfiguration extends IlluminateLoadConfig
{
	protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
	{
		$files = $this->getConfigurationFiles($app);

		foreach ($files as $key => $value) {
			$repository->set($key, $value);
		}
	}

	protected function getConfigurationFiles(Application $app)
	{
		$novaConfig = [];
		$appConfig = [];

		// Loop through the core config files
		foreach (Finder::create()->files()->name('*.php')->in($app->novaConfigPath()) as $file) {
			$key = basename($file->getRealPath(), '.php');

			$novaConfig[$key] = require $file->getRealPath();
		}

		// Loop through the "app" config files
		foreach (Finder::create()->files()->name('*.php')->in($app->configPath()) as $file) {
			$key = basename($file->getRealPath(), '.php');
			
			$appConfig[$key] = require $file->getRealPath();
		}

		return array_replace_recursive($novaConfig, $appConfig);
	}
}