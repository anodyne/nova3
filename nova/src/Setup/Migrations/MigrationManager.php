<?php namespace Nova\Setup\Migrations;

class MigrationManager
{
	public $data = [];

	protected $migrators = [
		'install' => Install::class,
		'genres' => Genres::class,
		'users' => Users::class,
		'characters' => Characters::class,
		'missions' => Missions::class,
	];

	public function run($migratorKey)
	{
		$migration = array_get($this->migrators, $migratorKey, false);

		if ($migration) {
			$migrator = new $migration(app('db'));

			return $migrator
				->getData()
				->migrate()
				->setData()
				->status();
		}
	}

	public function getData($key)
	{
		return array_get($this->data, $key, false);
	}

	public function setData(array $data)
	{
		$this->data = array_merge($this->data, $data);
	}
}
