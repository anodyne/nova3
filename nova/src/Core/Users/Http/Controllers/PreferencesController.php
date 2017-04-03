<?php namespace Nova\Core\Users\Http\Controllers;

use User;
use UserRepositoryContract;
use Illuminate\Http\Request;
use EditUserPreferencesRequest;
use Nova\Foundation\Http\Controllers\NovaController;

class PreferencesController extends NovaController
{
	protected $repo;

	public function __construct(UserRepositoryContract $repo)
	{
		parent::__construct();

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;

		$this->middleware('auth');
	}

	public function index()
	{
		$this->views->put('page', 'admin/users/preferences');

		$this->data->user = $this->user;

		$this->views->put('scripts', ['admin/users/preferences']);
	}

	public function update(EditUserPreferencesRequest $request)
	{
		return redirect()->back();
	}
}
