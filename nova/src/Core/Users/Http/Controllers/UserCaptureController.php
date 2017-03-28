<?php namespace Nova\Core\Users\Http\Controllers;

use User;
use BaseController;
use UserRepositoryContract;
use Illuminate\Http\Request;

class UserCaptureController extends BaseController
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

	public function export(Request $request, $userId)
	{
		// Get the user
		$user = $this->repo->findById($userId);

		if ($user) {
			// Make sure the user is allowed to export THIS user

			// If the user is trying to export their own user, they can always do it

			// If the user doesn't own the user, they have to have permissions X

			// Store the exported user as a text file and offer it up for download
		}
	}

	public function exportAll(Request $request)
	{
		// Get all users
		$users = $this->repo->all();

		if ($users->count() > 0) {
			// Only admins can export everything
			if (policy(new User)->exportAll($this->user)) {
				// Store the exported users as a text file and offer it up for download

				return response()->download($file, 'filename.json', $headers);
			}
		}
	}

	public function showImport()
	{
		// Modal pop up for importing a user record
	}

	public function import(Request $request)
	{
		// Import the user record into Nova

		// The only people that can import a user from the admin section are admins

		// Are we dealing with importing a single user or multiple users?
	}
}
