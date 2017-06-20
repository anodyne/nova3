<?php namespace Nova\Authorize\Http\Controllers;

use Nova\Authorize\Role;
use Illuminate\Http\Request;
use Nova\Foundation\Http\Controllers\Controller;

class RolesController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		// Authorize

		$roles = Role::get();

		return view('pages.authorize.all-roles', compact('roles'));
	}

	public function create()
	{
		// Authorize

		return view('pages.authorize.create-role');
	}

	public function store(Request $request)
	{
		// Authorize

		$this->validate($request, [
			'name' => 'required'
		]);

		Role::create($request->all());

		return redirect()->route('roles.index');
	}

	public function edit(Role $role)
	{
		// Authorize

		return view('pages.authorize.update-role', compact('role'));
	}

	public function update(Request $request, Role $role)
	{
		// Authorize

		$this->validate($request, [
			'name' => 'required'
		]);

		$role->fill($request->all())->save();

		return redirect()->route('roles.index');
	}

	public function destroy(Role $role)
	{
		// Authorize

		$role->delete();

		return redirect()->route('roles.index');
	}
}
