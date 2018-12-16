<?php

namespace Nova\Foundation\Bootstrap;

use Symfony\Component\Finder\Finder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as IlluminateLoadConfig;

class LoadConfiguration extends IlluminateLoadConfig
{
	protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
	{
		collect($this->getConfigurationFiles($app))
			->each(function ($values, $file) use (&$repository) {
				$repository->set($file, $values);
			});
	}

	protected function getConfigurationFiles(Application $app)
	{
		$novaConfig = [];
		$appConfig = [];

		foreach (Finder::create()->files()->name('*.php')->in($app->configPath()) as $file) {
			$key = basename($file->getRealPath(), '.php');

			$novaConfig[$key] = require $file->getRealPath();
		}

		foreach (Finder::create()->files()->name('*.php')->in($app->appConfigPath()) as $file) {
			$key = basename($file->getRealPath(), '.php');

			$appConfig[$key] = require $file->getRealPath();
		}

		return array_replace_recursive($novaConfig, $appConfig);
	}
}
