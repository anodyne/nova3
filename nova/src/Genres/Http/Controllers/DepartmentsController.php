<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\Department;

class DepartmentsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$deptClass = new Department;

		$this->authorize('manage', $deptClass);

		$this->views('genres.all-departments', 'page|script');

		$this->setPageTitle(_m('genre-depts', [2]));

		$this->data->deptClass = $deptClass;
		$this->data->departments = Department::with('subDepartments')
			->parents()
			->orderBy('order')->get();
	}

	public function create()
	{
		$this->authorize('create', new Department);

		$this->views('genres.create-department', 'page|script');

		$this->setPageTitle(_m('genre-depts-add'));
	}

	public function store()
	{
		$this->renderWithTheme = false;

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

		$this->views('genres.edit-department', 'page|script');

		$this->setPageTitle(_m('genre-depts-update'));

		$this->data->department = $department;
	}

	public function update(Department $department)
	{
		$this->renderWithTheme = false;

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
		$this->renderWithTheme = false;

		$this->authorize('delete', $department);

		deletor(Department::class)->delete($department);

		return response($department, 200);
	}
}
