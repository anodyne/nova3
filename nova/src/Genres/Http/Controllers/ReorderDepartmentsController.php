<?php namespace Nova\Genres\Http\Controllers;

use Controller;
use Nova\Genres\Department;

class ReorderDepartmentsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'structure|template');
	}

	public function index()
	{
		$this->authorize('update', new Department);

		$this->views('genres.reorder-departments', 'page|script');

		$this->pageTitle = _m('genre-depts-reorder');

		$this->data->departments = Department::with('subDepartments')
			->parents()
			->orderBy('order')->get();
	}

	public function update()
	{
		$this->renderWithTheme = false;

		$this->authorize('update', new Department);

		$departments = collect(request('depts'))->each(function ($id, $index) {
			$dept = Department::find($id);

			if ($dept) {
				$dept->reorder($index);
			}
		});

		return response(200);
	}
}
