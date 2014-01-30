<?php namespace Nova\Setup\Controllers;

use DB,
	Schema,
	SystemModel,
	Controller,
	SystemEvent,
	NovaCreateRanks,
	NovaCreatePositions,
	NovaCreateDepartments;

class AjaxController extends Controller {

	public function postIgnoreVersion()
	{
		// Update the system information table with the ignore version
		SystemModel::updateInfo(['ignore' => e(Input::get('version'))]);
	}

	public function postInstallGenre()
	{
		// Grab the genre
		$genre = trim(e(Input::get('genre')));

		// Create new instances of the migrations
		$depts = new NovaCreateDepartments;
		$positions = new NovaCreatePositions;
		$ranks = new NovaCreateRanks;

		// Install the items
		$depts->up($genre);
		$positions->up($genre);
		$ranks->up($genre);

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Try to get one of the tables
		$hasTable = Schema::hasTable("{$prefix}departments_{$genre}");

		if ($hasTable)
		{
			// Create an event
			SystemEvent::addUserEvent('event.setup.genre', $genre, lang('action.installed'));

			return json_encode(['code' => 1]);
		}

		return json_encode(['code' => 0]);
	}

	public function postUninstallGenre()
	{
		// Grab the genre
		$genre = trim(e(Input::get('genre')));

		// Create new instances of the migrations
		$depts = new NovaCreateDepartments;
		$positions = new NovaCreatePositions;
		$ranks = new NovaCreateRanks;

		// Drop the items
		$depts->down($genre);
		$positions->down($genre);
		$ranks->down($genre);

		// Get the table prefix
		$prefix = DB::getTablePrefix();

		// Try to get one of the tables
		$hasTable = Schema::hasTable("{$prefix}departments_{$genre}");

		if ( ! $hasTable)
		{
			// Create an event
			SystemEvent::addUserEvent('event.setup.genre', $genre, lang('action.removed'));

			return json_encode(['code' => 1]);
		}

		return json_encode(['code' => 0]);
	}

}