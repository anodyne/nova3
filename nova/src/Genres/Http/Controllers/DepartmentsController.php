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

		$departments = Department::with('subDepartments')->parents()->orderBy('order')->get();

		return view('pages.genres.all-departments', compact('deptClass', 'departments'));
	}

	public function create()
	{
		$this->authorize('create', new Department);

		return view('pages.genres.create-department');
	}

	public function store()
	{
		$this->authorize('create', new Department);

		$this->validate(request(), [
			'name' => 'required',
		], [
			'name.required' => _m('validation-name-required'),
		]);

		creator(Department::class)->with(request()->all())->create();

		flash()
			->title(_m('genre-depts-flash-added-title'))
			->message(_m('genre-depts-flash-added-message'))
			->success();

		return redirect()->route('departments.index');
	}

	public function edit(Department $department)
	{
		$this->authorize('update', $department);

		return view('pages.genres.edit-department', compact('department'));
	}

	public function update(Department $department)
	{
		$this->authorize('update', $department);

		$this->validate(request(), [
			'name' => 'required'
		], [
			'name.required' => _m('validation-name-required')
		]);

		updater(Department::class)->with(request()->all())->update($department);

		flash()
			->title(_m('genre-depts-flash-updated-title'))
			->message(_m('genre-depts-flash-updated-message'))
			->success();

		return redirect()->route('departments.index');
	}

	public function destroy(Department $department)
	{
		$this->authorize('delete', $department);

		deletor(Department::class)->delete($department);

		return response($department, 200);
	}
}
