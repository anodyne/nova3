<?php namespace Nova\Core\Users\Http\Controllers;

use User,
	BaseController,
	UserRepositoryContract,
	EditUserPreferencesRequest;
use Illuminate\Http\Request;

class PreferencesController extends BaseController {

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
