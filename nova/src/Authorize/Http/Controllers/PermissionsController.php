<?php namespace Nova\Authorize\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Authorize\Permission;
use Nova\Foundation\Http\Controllers\Controller;

class PermissionsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		// Authorize

		$permissions = Permission::get();

		return view('pages.authorize.all-permissions', compact('permissions'));
	}

	public function create()
	{
		// Authorize

		return view('pages.authorize.create-permission');
	}

	public function store(Request $request)
	{
		// Authorize

		$this->validate($request, [
			'name' => 'required',
			'key' => 'required'
		]);

		Permission::create($request->all());

		return redirect()->route('permissions.index');
	}

	public function edit(Permission $permission)
	{
		// Authorize

		return view('pages.authorize.update-permission', compact('permission'));
	}

	public function update(Request $request, Permission $permission)
	{
		// Authorize

		$this->validate($request, [
			'name' => 'required',
			'key' => 'required'
		]);

		$permission->fill($request->all())->save();

		return redirect()->route('permissions.index');
	}

	public function destroy(Permission $permission)
	{
		// Authorize

		$permission->delete();

		return redirect()->route('permissions.index');
	}
}
