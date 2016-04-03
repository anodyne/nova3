<?php namespace Nova\Core\Forms\Http\Controllers;

use Request,
	BaseController,
	FormRepositoryInterface;
use Nova\Core\Forms\Events;

class FormViewerController extends BaseController {

	protected $formRepo;

	public function __construct(FormRepositoryInterface $forms)
	{
		$this->formRepo = $forms;

		$this->structureView = 'admin';
		$this->templateView = 'admin';
	}

	public function store(Request $request, $formKey)
	{
		$form = $this->formRepo->getByKey($formKey);

		// Validate the request
		$this->validate($request, $this->formRepo->getValidationRules($form));

		$entry = $this->repo->create($request->all());

		event(new Events\FormViewerFormWasCreated($entry));

		flash()->success("Form Submitted!");

		return redirect()->back();
	}

	public function update(Request $request, $formKey, $id)
	{
		$form = $this->formRepo->getByKey($formKey);

		// Validate the request
		$this->validate($request, $this->formRepo->getValidationRules($form));

		$entry = $this->repo->update($id, $request->all());

		event(new Events\FormViewerFormWasUpdated($entry));

		flash()->success("Form Updated!");

		return redirect()->back();
	}

}
