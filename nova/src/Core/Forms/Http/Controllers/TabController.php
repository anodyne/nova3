<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaFormTab,
	BaseController,
	FormRepositoryInterface,
	FormTabRepositoryInterface,
	EditTabRequest, CreateTabRequest, RemoveTabRequest;
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

		$this->data->tab = new NovaFormTab;
		$tabs = $this->data->tabs = $this->repo->getFormTabs($form);
		$this->data->hasTabs = $tabs->count();
	}

	public function create($formKey)
	{
		$form = $this->data->form = $this->formRepo->findByKey($formKey);

		$this->authorize('create', new NovaFormTab, "You do not have permission to create form tabs.");

		$this->view = 'admin/forms/tab-create';
		$this->jsView = 'admin/forms/tab-create-js';
	}

	public function store(CreateTabRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormTab, "You do not have permission to create form tabs.");

		$tab = $this->repo->create($request->all());

		event(new Events\TabWasCreated($tab));

		flash()->success("Form Tab Created!", "You can begin designing the tab layout with sections and fields.");

		return redirect()->route('admin.forms.tabs', [$formKey]);
	}

	public function edit($formKey)
	{
		$form = $this->data->form = $this->repo->findByKey($formKey);

		$this->authorize('edit', $form, "You do not have permission to edit forms.");

		$this->view = 'admin/forms/form-edit';
		$this->jsView = 'admin/forms/form-edit-js';
	}

	public function update(EditTabRequest $request, $formKey)
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

	public function destroy(RemoveTabRequest $request, $formKey)
	{
		$form = $this->repo->findByKey($formKey);

		$this->authorize('remove', $form, "You do not have permission to remove forms.");

		$form = $this->repo->delete($form);

		event(new Events\FormWasDeleted($form->name, $form->key));

		flash()->success("Form Removed!");

		return redirect()->route('admin.forms');
	}

	public function checkTabLink()
	{
		$this->isAjax = true;

		$form = $this->formRepo->findByKey(request('formKey'));

		$count = $this->repo->countLinkIds($form, request('linkId'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
