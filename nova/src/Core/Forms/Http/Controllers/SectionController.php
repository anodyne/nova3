<?php namespace Nova\Core\Forms\Http\Controllers;

use BaseController,
	NovaFormSection,
	FormRepositoryContract,
	FormTabRepositoryContract,
	FormSectionRepositoryContract,
	EditFormSectionRequest, CreateFormSectionRequest, RemoveFormSectionRequest;

class SectionController extends BaseController {

	protected $repo;
	protected $tabRepo;
	protected $formRepo;

	public function __construct(FormSectionRepositoryContract $repo, 
			FormRepositoryContract $forms,
			FormTabRepositoryContract $tabs)
	{
		parent::__construct();

		$this->structureView = 'admin';
		$this->templateView = 'admin';
		$this->isAdmin = true;

		$this->repo = $repo;
		$this->tabRepo = $tabs;
		$this->formRepo = $forms;

		$this->middleware('auth');
	}

	public function all($formKey)
	{
		$section = $this->data->section = new NovaFormSection;

		$this->authorize('manage', $section, "You do not have permission to manage form sections.");

		$this->view = 'admin/forms/sections';
		$this->scripts = [
			'Sortable.min',
			'admin/forms/sections',
		];
		$this->styles = ['uikit/components/icon'];

		$form = $this->data->form = $this->formRepo->getByKey($formKey, ['tabsAll', 'tabsAll.sectionsAll', 'sectionsUnboundAll']);

		$this->data->tabs = $this->tabRepo->getFormTabs($form, [], true);
		
		$this->data->unboundSections = $this->repo->getUnboundSections($form, [], true);

		$this->jsData->orderUpdateUrl = route('admin.forms.sections.updateOrder');
	}

	public function create($formKey)
	{
		$this->authorize('create', new NovaFormSection, "You do not have permission to create form sections.");

		$this->view = 'admin/forms/section-create';
		$this->scripts = ['admin/forms/section-create'];

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->tabs = ['0' => "No tab"];
		$this->data->tabs+= $this->tabRepo->listAll('name', 'id');
	}

	public function store(CreateFormSectionRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormSection, "You do not have permission to create form sections.");

		$section = $this->repo->create($request->all());

		flash()->success("Form Section Created!", "You can begin designing the section layout with fields.");

		return redirect()->route('admin.forms.sections', [$formKey]);
	}

	public function edit($formKey, $sectionId)
	{
		$section = $this->data->section = $this->repo->getById($sectionId);

		$this->authorize('edit', $section, "You do not have permission to edit form sections.");

		$this->view = 'admin/forms/section-edit';
		$this->scripts = ['admin/forms/section-edit'];

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->tabs = ['0' => "No tab"];
		$this->data->tabs+= $this->tabRepo->listAll('name', 'id');
	}

	public function update(EditFormSectionRequest $request, $formKey, $sectionId)
	{
		$this->authorize('edit', new NovaFormSection, "You do not have permission to edit form sections.");

		$section = $this->repo->update($sectionId, $request->all());

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
			$form = $this->formRepo->getByKey($formKey);

			$sections = ['0' => "No section"];
			$sections+= $this->repo->listAll('name', 'id');

			$body = (policy($section)->remove($this->user, $section))
				? view(locate('page', 'admin/forms/section-remove'), compact('form', 'section', 'sections'))
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

		$this->authorize('remove', $section, "You do not have permission to remove form sections.");

		if ($request->has('remove_section_content'))
		{
			$this->repo->removeSectionContent($section);
		}
		else
		{
			$this->repo->reassignSectionContent($section, $request->get('new_section'));
		}

		$section = $this->repo->delete($section);

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
			}
		}
	}

}
