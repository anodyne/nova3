<?php namespace Nova\Setup\Migrations;

use Illuminate\Database\DatabaseManager;

abstract class Migrator
{
	protected $db;

	public function __construct(DatabaseManager $db)
	{
		$this->db = $db->connection('nova2');
	}

	public function getData()
	{
		return $this;
	}

	public function setData()
	{
		return $this;
	}
}
