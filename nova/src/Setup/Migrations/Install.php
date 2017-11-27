<?php namespace Nova\Setup\Migrations;

use Artisan;

class Install extends Migrator implements Migratable
{
	public function migrate()
	{
		if (! $this->check()) {
			Artisan::call('nova:install');
		}

		return $this;
	}

	public function check()
	{
		return nova()->isInstalled();
	}

	public function status()
	{
		if ($this->check()) {
			return ['status' => 'success', 'message' => ''];
		}

		return [
			'status' => 'failed',
			'message' => config('nova.app.name')." was not installed because of an unknown error."
		];
	}
}
