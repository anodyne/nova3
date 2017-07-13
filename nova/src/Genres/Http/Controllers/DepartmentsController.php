<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\Department;

class DepartmentsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$deptClass = new Department;

		$this->authorize('manage', $deptClass);

		$departments = Department::with('subDepartments')->parents()->get();

		return view('pages.genres.all-departments', compact('deptClass', 'departments'));
	}

	public function create()
	{
		$this->authorize('create', new Department);

		// Get all of the departments that are parents
		$parentDepartments = Department::parents()->get()->pluck('name', 'id');

		return view('pages.genres.create-department', compact('parentDepartments'));
	}

	public function store()
	{
		$this->authorize('create', new Department);

		$this->validate(request(), [
			'name' => 'required',
		], [
			'name.required' => _m('validation-required-name'),
		]);

		creator(Department::class)->with(request()->all())->create();

		flash()
			->title(_m('genre-dept-flash-added-title'))
			->message(_m('genre-dept-flash-added-message'))
			->success();

		return redirect()->route('departments.index');
	}

	public function edit(Department $department)
	{
		$this->authorize('update', $department);

		// Get all of the departments that are parents
		$parentDepartments = Department::parents()->get()->pluck('name', 'id');

		return view('pages.genres.update-department', compact('department', 'parentDepartments'));
	}

	public function update(Department $department)
	{
		$this->authorize('update', $department);

		$this->validate(request(), [
			'name' => 'required'
		], [
			'name.required' => _m('validation-required-name')
		]);

		updater(Department::class)->with(request()->all())->update($department);

		flash()
			->title(_m('genre-dept-flash-updated-title'))
			->message(_m('genre-dept-flash-updated-message'))
			->success();

		return redirect()->route('departments.index');
	}

	public function destroy(Department $department)
	{
		$this->authorize('delete', $department);

		deletor(Department::class)->delete($department);

		flash()
			->title(_m('genre-dept-flash-deleted-title'))
			->message(_m('genre-dept-flash-deleted-message'))
			->success();

		return redirect()->route('departments.index');
	}
}
