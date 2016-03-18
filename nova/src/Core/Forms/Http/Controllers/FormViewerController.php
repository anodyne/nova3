<?php namespace Nova\Core\Forms\Http\Controllers;

use Request, BaseController;
use Nova\Core\Forms\Events;

class FormViewerController extends BaseController {

	public function __construct()
	{
		$this->structureView = 'admin';
		$this->templateView = 'admin';
	}

	public function store(Request $request, $formKey)
	{
		$form = $formRepo->getByKey($formKey);

		// Get the validation rules for the form
		$validationRules = $formRepo->getValidationRules($form);

		// Validate the request
		$this->validate($request, $validationRules);

		$entry = $this->repo->create($request->all());

		event(new Events\FormViewerFormWasCreated($entry));

		flash()->success("Form Submitted!");

		return redirect()->back();
	}

	public function update(Request $request, $formKey, $id)
	{
		$form = $formRepo->getByKey($formKey);

		// Get the validation rules for the form
		$validationRules = $formRepo->getValidationRules($form);

		// Validate the request
		$this->validate($request, $validationRules);

		$entry = $this->repo->update($id, $request->all());

		event(new Events\FormViewerFormWasUpdated($entry));

		flash()->success("Form Updated!");

		return redirect()->back();
	}

}
