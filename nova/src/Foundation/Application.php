<?php namespace Nova\Foundation;

use Illuminate\Foundation\Application as LaravelApp;

class Application extends LaravelApp
{
	public function bootstrapPath($path = '')
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'bootstrap',
			$path
		]);
	}

	public function configPath($path = '')
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'config',
			$path
		]);
	}

	public function databasePath($path = '')
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'database',
			$path
		]);
	}

	public function langPath()
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'resources',
			'lang'
		]);
	}

	public function novaConfigPath($path = '')
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'config',
			$path
		]);
	}

	public function novaLangPath()
	{
		return $this->resourcePath('lang');
	}

	public function path($path = '')
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'src',
			$path
		]);
	}

	public function publicPath()
	{
		return $this->basePath;
	}

	public function resourcePath($path = '')
	{
		return join(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'resources',
			$path
		]);
	}

	protected function bindPathsInContainer()
	{
		parent::bindPathsInContainer();

		$this->instance('path.nova.lang', $this->novaLangPath());
	}
}
