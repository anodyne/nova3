<?php namespace Nova\Core\Forms\Http\Controllers;

use BaseController,
	FormRepositoryInterface,
	FormTabRepositoryInterface,
	EditFormRequest, CreateFormRequest, RemoveFormRequest;
use Nova\Core\Forms\Events;

class TabController extends BaseController {

	protected $repo;
	protected $formRepo;

	public function __construct(FormTabRepositoryInterface $repo, 
		FormRepositoryInterface $forms)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->formRepo = $forms;

		$this->middleware('auth');
	}

	public function index($formKey)
	{
		$form = $this->data->form = $this->formRepo->findByKey($formKey);

		$this->authorize('manage', $form, "You do not have permission to manage forms.");

		$this->view = 'admin/forms/tabs';
		$this->jsView = 'admin/forms/tabs-js';

		$this->data->tabs = $this->repo->getFormTabs($form);
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
		$form = $this->data->form = $this->repo->findByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$this->view = 'admin/forms/form-edit';
		$this->jsView = 'admin/forms/form-edit-js';
	}

	public function update(EditFormRequest $request, $formKey)
	{
		$form = $this->repo->findByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$form = $this->repo->update($form, $request->all());

		event(new Events\FormWasUpdated($form));

		flash()->success("Form Updated!");

		return redirect()->route('admin.forms');
	}

	public function remove($formKey)
	{
		$this->isAjax = true;

		$form = $this->repo->findByKey($formKey);

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
		$form = $this->repo->findByKey($formKey);

		$this->authorize('remove', $form, "You do not have permission to remove forms.");

		$form = $this->repo->delete($form);

		event(new Events\FormWasDeleted($form->name, $form->key));

		flash()->success("Form Removed!");

		return redirect()->route('admin.forms');
	}

}
