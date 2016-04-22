<?php namespace Nova\Core\Users\Http\Controllers;

use User,
	BaseController,
	UserRepositoryContract,
	EditUserRequest, CreateUserRequest, RemoveUserRequest;
use Nova\Core\Users\Events;

class UserController extends BaseController {

	protected $repo;

	public function __construct(UserRepositoryContract $repo)
	{
		parent::__construct();

		$this->structureView = 'admin';
		$this->templateView = 'admin';

		$this->repo = $repo;

		$this->middleware('auth');
	}

	public function all()
	{
		$user = $this->data->user = new User;

		$this->authorize('manage', $user, "You do not have permission to manage users.");

		$this->view = 'admin/users/users';
		$this->jsView = 'admin/users/users-js';

		$this->data->users = $this->repo->all();
	}

	public function create()
	{
		$this->authorize('create', new NovaForm, "You do not have permission to create forms.");

		$this->view = 'admin/forms/form-create';
		$this->jsView = 'admin/forms/form-create-js';

		$this->data->accessRoles = $this->roleRepo->listAll('display_name', 'name');

		$this->data->resourcesCreate = $this->pageRepo->listAllBy('verb', 'POST', 'name', 'key');
		$this->data->resourcesUpdate = $this->pageRepo->listAllBy('verb', 'PUT', 'name', 'key');
		$this->data->resourcesDelete = $this->pageRepo->listAllBy('verb', 'DELETE', 'name', 'key');
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

		$this->data->accessRoles = $this->roleRepo->listAll('display_name', 'name');

		$this->data->resourcesCreate = $this->pageRepo->listAllBy('verb', 'POST', 'name', 'key');
		$this->data->resourcesUpdate = $this->pageRepo->listAllBy('verb', 'PUT', 'name', 'key');
		$this->data->resourcesDelete = $this->pageRepo->listAllBy('verb', 'DELETE', 'name', 'key');

		$this->data->fields = $form->fields->pluck('label', 'id');

		$this->jsData->form = $form->toJson();
		$this->jsData->restrictions = ($form->restrictions) ? $form->restrictions->toJson() : null;
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
