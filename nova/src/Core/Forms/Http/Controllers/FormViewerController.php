<?php namespace Nova\Core\Forms\Http\Controllers;

use Request, BaseController;
use Nova\Core\Forms\Events;

class FormViewerController extends BaseController {

	public function __construct()
	{
		$this->structureView = 'admin';
		$this->templateView = 'admin';
	}

	public function store(Request $request)
	{
		// Validate

		$entry = $this->repo->create($request->all());

		event(new Events\FormViewerFormWasCreated($entry));

		flash()->success("Form Submitted!");

		return redirect()->back();
	}

	public function update(Request $request, $id)
	{
		// Validate

		$entry = $this->repo->update($id, $request->all());

		event(new Events\FormViewerFormWasUpdated($entry));

		flash()->success("Form Updated!");

		return redirect()->back();
	}

}
