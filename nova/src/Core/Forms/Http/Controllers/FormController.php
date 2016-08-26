<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaForm,
	NovaFormTab,
	NovaFormField,
	BaseController,
	NovaFormSection,
	FormRepositoryContract,
	PageRepositoryContract,
	RoleRepositoryContract,
	EditFormRequest, CreateFormRequest, RemoveFormRequest;

class FormController extends BaseController {

	protected $repo;
	protected $pageRepo;
	protected $roleRepo;

	public function __construct(FormRepositoryContract $repo,
			PageRepositoryContract $pages,
			RoleRepositoryContract $roles)
	{
		parent::__construct();

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;
		$this->pageRepo = $pages;
		$this->roleRepo = $roles;

		$this->middleware('auth');
	}

	public function all()
	{
		$form = $this->data->form = new NovaForm;

		$this->authorize('manage', $form, "You do not have permission to manage forms.");

		$this->views->put('page', 'admin/forms/forms');
		$this->views->put('scripts', ['admin/forms/forms']);

		$this->data->forms = $this->repo->all();

		$this->data->formTab = new NovaFormTab;
		$this->data->formField = new NovaFormField;
		$this->data->formSection = new NovaFormSection;

		$this->data->keyCheckUrl = route('admin.forms.checkKey');
	}

	public function create()
	{
		$this->authorize('create', new NovaForm, "You do not have permission to create forms.");

		$this->views->put('page', 'admin/forms/form-create');
		$this->views->put('scripts', ['admin/forms/form-create']);

		$this->data->accessRoles = $this->roleRepo->listAll('name', 'key');

		$this->data->resourcesCreate = $this->pageRepo->listAllBy('verb', 'POST', 'name', 'key');
		$this->data->resourcesUpdate = $this->pageRepo->listAllBy('verb', 'PUT', 'name', 'key');
		$this->data->resourcesDelete = $this->pageRepo->listAllBy('verb', 'DELETE', 'name', 'key');
	}

	public function store(CreateFormRequest $request)
	{
		$this->authorize('create', new NovaForm, "You do not have permission to create forms.");

		$form = $this->repo->create($request->all());

		flash()->success("Form Created!", "You can begin designing your form now with tabs, sections, and fields.");

		return redirect()->route('admin.forms');
	}

	public function edit($formKey)
	{
		$form = $this->data->form = $this->repo->getByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$this->views->put('page', 'admin/forms/form-edit');
		$this->views->put('scripts', ['admin/forms/form-edit']);

		$this->data->accessRoles = $this->roleRepo->listAll('name', 'key');

		$this->data->resourcesCreate = $this->pageRepo->listAllBy('verb', 'POST', 'name', 'key');
		$this->data->resourcesUpdate = $this->pageRepo->listAllBy('verb', 'PUT', 'name', 'key');
		$this->data->resourcesDelete = $this->pageRepo->listAllBy('verb', 'DELETE', 'name', 'key');

		$this->data->fields = $form->fields->pluck('label', 'id');

		$this->data->keyCheckUrl = route('admin.forms.checkKey');
		$this->data->formArr = $form->toArray();
		$this->data->restrictions = ($form->restrictions) ? $form->restrictions->toArray() : null;
	}

	public function update(EditFormRequest $request, $formKey)
	{
		$form = $this->repo->getByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$form = $this->repo->update($form, $request->all());

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
			$body = (policy($form)->remove(user(), $form))
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

		flash()->success("Form Removed!");

		return redirect()->route('admin.forms');
	}

	public function preview($formKey)
	{
		$this->views->put('page', 'admin/forms/form-preview');
		$this->views->put('scripts', [
			'bootstrap-tabdrop',
			'admin/forms/form-preview'
		]);

		$this->data->form = $this->repo->getByKey($formKey);
	}

	public function checkFormKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', request('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
