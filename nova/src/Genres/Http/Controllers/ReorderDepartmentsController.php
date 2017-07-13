<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\Department;

class ReorderDepartmentsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$this->authorize('update', new Department);

		$departments = Department::with('subDepartments')->parents()->orderBy('order')->get();

		return view('pages.genres.reorder-departments', compact('departments'));
	}

	public function update()
	{
		$this->authorize('update', new Department);

		$departments = collect(request('depts'))->each(function ($id, $index) {
			Department::find($id)->reorder($index);
		});

		return response([200]);
	}
}
