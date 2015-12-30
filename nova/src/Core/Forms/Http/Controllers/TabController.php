<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaFormTab,
	BaseController,
	FormRepositoryInterface,
	FormTabRepositoryInterface,
	EditFormTabRequest, CreateFormTabRequest, RemoveFormTabRequest;
use Nova\Core\Forms\Events;

class TabController extends BaseController {

	protected $repo;
	protected $formRepo;

	public function __construct(FormTabRepositoryInterface $repo, 
		FormRepositoryInterface $forms)
	{
		parent::__construct();

		$this->structureView = 'admin';
		$this->templateView = 'admin';

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

		$this->data->parentTabs = ['' => "No parent tab"];
		$this->data->parentTabs += $this->repo->listParentTabs($form);
	}

	public function store(CreateFormTabRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormTab, "You do not have permission to create form tabs.");

		$tab = $this->repo->create($request->all());

		event(new Events\FormTabWasCreated($tab));

		flash()->success("Form Tab Created!", "You can begin designing the tab layout with sections and fields.");

		return redirect()->route('admin.forms.tabs', [$formKey]);
	}

	public function edit($formKey, $tabId)
	{
		$form = $this->data->form = $this->formRepo->findByKey($formKey);

		$tab = $this->data->tab = $this->repo->find($tabId);

		$this->authorize('edit', $tab, "You do not have permission to edit form tabs.");

		$this->view = 'admin/forms/tab-edit';
		$this->jsView = 'admin/forms/tab-edit-js';

		$this->data->parentTabs = ['' => "No parent tab"];
		$this->data->parentTabs += $this->repo->listParentTabs($form);
	}

	public function update(EditFormTabRequest $request, $formKey, $tabId)
	{
		$form = $this->formRepo->findByKey($formKey);

		$tab = $this->repo->find($tabId);

		$this->authorize('edit', $tab, "You do not have permission to edit form tabs.");

		$tab = $this->repo->update($tab, $request->all());

		event(new Events\FormTabWasUpdated($tab));

		flash()->success("Form Tab Updated!");

		return redirect()->route('admin.forms.tabs', [$formKey]);
	}

	public function remove($formKey, $tabId)
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

	public function updateTabOrder()
	{
		$this->isAjax = true;

		$tab = new NovaFormTab;

		if (policy($tab)->edit($this->user, $tab))
		{
			foreach (request('tab') as $key => $value)
			{
				$updatedTab = $this->repo->updateOrder($value, $key++);

				event(new Events\FormTabOrderWasUpdated($updatedTab));
			}
		}
	}

}
