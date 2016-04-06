<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaForm,
	NovaFormTab,
	NovaFormField,
	BaseController,
	NovaFormSection,
	FormRepositoryInterface,
	EditFormRequest, CreateFormRequest, RemoveFormRequest;
use Nova\Core\Forms\Events;

class FormCenterController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		$this->structureView = 'admin';
		$this->templateView = 'admin';

		$this->middleware('auth');
	}

	public function index()
	{
		$form = $this->data->form = new NovaForm;

		$this->authorize('manage', $form, "You do not have permission to manage forms.");

		$this->view = 'admin/forms/forms';
		$this->jsView = 'admin/forms/forms-js';

		$this->data->forms = $this->repo->all();

		$this->data->formTab = new NovaFormTab;
		$this->data->formField = new NovaFormField;
		$this->data->formSection = new NovaFormSection;
	}

	public function create()
	{
		$this->authorize('create', new NovaForm, "You do not have permission to create forms.");

		$this->view = 'admin/forms/form-create';
		$this->jsView = 'admin/forms/form-create-js';
	}

	public function store(CreateFormRequest $request)
	{
		$this->authorize('create', new NovaForm, "You do not have permission to create forms.");

		$form = $this->repo->create($request->all());

		event(new Events\FormWasCreated($form));

		flash()->success("Form Created!", "You can begin designing your form now with tabs, sections, and fields.");

		return redirect()->route('admin.forms');
	}

	public function edit($formKey)
	{
		$form = $this->data->form = $this->repo->getByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$this->view = 'admin/forms/form-edit';
		$this->jsView = 'admin/forms/form-edit-js';
	}

	public function update(EditFormRequest $request, $formKey)
	{
		$form = $this->repo->getByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$form = $this->repo->update($form, $request->all());

		event(new Events\FormWasUpdated($form));

		flash()->success("Form Updated!");

		return redirect()->route('admin.forms');
	}

	public function remove($formKey)
	{
		$this->isAjax = true;

		$form = $this->repo->getByKey($formKey);

		if ( ! $form)
		{
			$body = alert('danger', "Form [{$formKey}] not found.");
		}
		else
		{
			$body = (policy($form)->remove($this->user, $form))
				? view(locate('page', 'admin/forms/form-remove'), compact('form'))
				: alert('danger', "You do not have permission to remove forms.");
		}

		return partial('modal-content', [
			'header' => "Remove Form",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveFormRequest $request, $formKey)
	{
		$form = $this->repo->getByKey($formKey);

		$this->authorize('remove', $form, "You do not have permission to remove forms.");

		$form = $this->repo->delete($form);

		event(new Events\FormWasDeleted($form->name, $form->key));

		flash()->success("Form Removed!");

		return redirect()->route('admin.forms');
	}

}
