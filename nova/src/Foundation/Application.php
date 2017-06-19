<?php namespace Nova\Foundation;

use Illuminate\Foundation\Application as LaravelApp;

class Application extends LaravelApp
{
	public function bootstrapPath($path = '')
	{
		return implode(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'bootstrap',
			$path
		]);
	}

	public function configPath($path = '')
	{
		return implode(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'config',
			$path
		]);
	}

	public function databasePath($path = '')
	{
		return implode(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'database',
			$path
		]);
	}

	public function publicPath()
	{
		return $this->basePath;
	}

	public function resourcePath($path = '')
	{
		return implode(DIRECTORY_SEPARATOR, [
			$this->basePath,
			'nova',
			'resources',
			$path
		]);
	}
}
