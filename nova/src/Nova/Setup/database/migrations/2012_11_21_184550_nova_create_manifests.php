<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateManifests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manifests', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('order')->nullable();
			$t->text('desc')->nullable();
			$t->text('header_content')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->boolean('default')->default((int) false);
		});

		// Data to seed the database with
		$data = array(
			array(
				'name' => 'Primary Manifest',
				'order' => 0,
				'desc' => "",
				'header_content' => "You can edit the header content of this manifest from Manifest Management...",
				'default' => (int) true),
		);

		// Loop through and add the data
		foreach ($data as $d)
		{
			ManifestModel::createItem($d);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manifests');
	}

}