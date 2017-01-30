<?php namespace Nova\Setup\Http\Controllers;

// The new database cannot have the same database prefix as the old database

class MigrateController extends BaseController {

	public function index()
	{
		return view('pages.setup.migrate.landing');
	}
}
