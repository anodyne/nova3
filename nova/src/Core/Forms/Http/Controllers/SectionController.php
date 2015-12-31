<?php namespace Nova\Core\Forms\Http\Controllers;

use BaseController,
	NovaFormSection,
	FormRepositoryInterface,
	FormTabRepositoryInterface,
	FormSectionRepositoryInterface,
	EditFormSectionRequest, CreateFormSectionRequest, RemoveFormSectionRequest;
use Nova\Core\Forms\Events;

class SectionController extends BaseController {

	protected $repo;
	protected $tabRepo;
	protected $formRepo;

	public function __construct(FormSectionRepositoryInterface $repo, 
		FormRepositoryInterface $forms,
		FormTabRepositoryInterface $tabs)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->tabRepo = $tabs;
		$this->formRepo = $forms;

		$this->middleware('auth');
	}

	public function index($formKey)
	{
		$section = $this->data->section = new NovaFormSection;

		$this->authorize('manage', $section, "You do not have permission to manage form sections.");

		$this->view = 'admin/forms/sections';
		$this->jsView = 'admin/forms/sections-js';
		$this->styleView = 'admin/forms/sections-style';

		$form = $this->data->form = $this->formRepo->findByKey($formKey, ['sections', 'sections.tab']);

		$this->data->tabs = $this->tabRepo->getFormTabs($form, ['sections']);
		
		$this->data->unboundSections = $this->repo->getUnboundSections($form);
	}

	public function create($formKey)
	{
		$this->authorize('create', new NovaFormSection, "You do not have permission to create form sections.");

		$this->view = 'admin/forms/section-create';
		$this->jsView = 'admin/forms/section-create-js';

		$form = $this->data->form = $this->formRepo->findByKey($formKey);

		$this->data->tabs = ['' => "No tab"];
		$this->data->tabs += $this->tabRepo->listAll('name', 'id');
	}

	public function store(CreateFormSectionRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormSection, "You do not have permission to create form sections.");

		$section = $this->repo->create($request->all());

		event(new Events\FormSectionWasCreated($section));

		flash()->success("Form Section Created!", "You can begin designing the section layout with fields.");

		return redirect()->route('admin.forms.sections', [$formKey]);
	}

	public function edit($formKey, $sectionId)
	{
		$section = $this->data->section = $this->repo->getById($sectionId);

		$this->authorize('edit', $section, "You do not have permission to edit form sections.");

		$this->view = 'admin/forms/section-edit';
		$this->jsView = 'admin/forms/section-edit-js';

		$form = $this->data->form = $this->formRepo->findByKey($formKey);

		$this->data->tabs = ['' => "No tab"];
		$this->data->tabs += $this->tabRepo->listAll('name', 'id');
	}

	public function update(EditFormSectionRequest $request, $formKey, $sectionId)
	{
		$section = $this->repo->getById($sectionId);

		$this->authorize('edit', $section, "You do not have permission to edit form sections.");

		$section = $this->repo->update($section, $request->all());

		event(new Events\FormSectionWasUpdated($section));

		flash()->success("Form Section Updated!");

		return redirect()->route('admin.forms.sections', [$formKey]);
	}

	public function remove($formKey, $sectionId)
	{
		$this->isAjax = true;

		$section = $this->repo->getById($sectionId);

		if ( ! $section)
		{
			$body = alert('danger', "Form section could not be found.");
		}
		else
		{
			$form = $this->formRepo->findByKey($formKey);

			$body = (policy($section)->remove($this->user, $section))
				? view(locate('page', 'admin/forms/section-remove'), compact('form', 'section'))
				: alert('danger', "You do not have permission to remove form sections.");
		}

		return partial('modal-content', [
			'header' => "Remove Form Section",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveFormSectionRequest $request, $formKey, $sectionId)
	{
		$section = $this->repo->getById($sectionId);

		$form = $this->formRepo->findByKey($formKey);

		$this->authorize('remove', $section, "You do not have permission to remove form sections.");

		$section = $this->repo->delete($section);

		event(new Events\FormSectionWasDeleted($section->id, $section->name, $form->key));

		flash()->success("Form Section Removed!");

		return redirect()->route('admin.forms.sections', [$formKey]);
	}

	public function updateSectionOrder()
	{
		$this->isAjax = true;

		$section = new NovaFormSection;

		if (policy($section)->edit($this->user, $section))
		{
			foreach (request('sections') as $order => $id)
			{
				$updatedSection = $this->repo->updateOrder($id, $order);

				event(new Events\FormSectionOrderWasUpdated($updatedSection));
			}
		}
	}

}
