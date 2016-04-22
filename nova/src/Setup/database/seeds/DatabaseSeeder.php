<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');
		$this->call('FormSeeder');
		$this->call('UserSeeder');
	}

}
