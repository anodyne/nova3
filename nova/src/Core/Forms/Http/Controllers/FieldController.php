<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaFormField,
	BaseController,
	FormRepositoryInterface,
	FormTabRepositoryInterface,
	FormFieldRepositoryInterface,
	FormSectionRepositoryInterface,
	EditFormFieldRequest, CreateFormFieldRequest, RemoveFormFieldRequest;
use Nova\Core\Forms\Events;

class FieldController extends BaseController {

	protected $repo;
	protected $tabRepo;
	protected $formRepo;
	protected $sectionRepo;

	public function __construct(FormFieldRepositoryInterface $repo,
		FormSectionRepositoryInterface $sections, 
		FormRepositoryInterface $forms,
		FormTabRepositoryInterface $tabs)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->tabRepo = $tabs;
		$this->formRepo = $forms;
		$this->sectionRepo = $sections;

		$this->middleware('auth');
	}

	public function index($formKey)
	{
		$field = $this->data->field = new NovaFormField;

		$this->authorize('manage', $field, "You do not have permission to manage form fields.");

		$this->view = 'admin/forms/fields';
		$this->jsView = 'admin/forms/fields-js';
		$this->styleView = 'admin/forms/fields-style';

		$form = $this->data->form = $this->formRepo->getByKey($formKey, ['fields', 'fields.values', 'sections', 'sections.fields', 'sections.fields.values', 'tabs', 'tabs.fields', 'tabs.fields.values', 'tabs.sections', 'tabs.sections.fields', 'tabs.sections.fields.values', 'tabs.childrenTabs', 'tabs.childrenTabs.fields', 'tabs.childrenTabs.fields.values', 'tabs.childrenTabs.sections', 'tabs.childrenTabs.sections.fields', 'tabs.childrenTabs.sections.fields.values']);

		$this->data->unboundFields = $this->formRepo->getUnboundFields($form);

		$this->data->unboundSections = $this->formRepo->getUnboundSections($form);

		$this->data->tabs = $this->formRepo->getTabs($form);
	}

	public function create($formKey)
	{
		$this->authorize('create', new NovaFormSection, "You do not have permission to create form sections.");

		$this->view = 'admin/forms/section-create';
		$this->jsView = 'admin/forms/section-create-js';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->tabs = ['' => "No tab"];
		$this->data->tabs += $this->tabRepo->listAll('name', 'id');
	}

	public function store(CreateFormFieldRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormSection, "You do not have permission to create form sections.");

		$section = $this->repo->create($request->all());

		event(new Events\FormFieldWasCreated($section));

		flash()->success("Form Section Created!", "You can begin designing the section layout with fields.");

		return redirect()->route('admin.forms.sections', [$formKey]);
	}

	public function edit($formKey, $sectionId)
	{
		$section = $this->data->section = $this->repo->getById($sectionId);

		$this->authorize('edit', $section, "You do not have permission to edit form sections.");

		$this->view = 'admin/forms/section-edit';
		$this->jsView = 'admin/forms/section-edit-js';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->tabs = ['' => "No tab"];
		$this->data->tabs += $this->tabRepo->listAll('name', 'id');
	}

	public function update(EditFormFieldRequest $request, $formKey, $sectionId)
	{
		$section = $this->repo->getById($sectionId);

		$this->authorize('edit', $section, "You do not have permission to edit form sections.");

		$section = $this->repo->update($section, $request->all());

		event(new Events\FormFieldWasUpdated($section));

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

	public function destroy(RemoveFormFieldRequest $request, $formKey, $sectionId)
	{
		$section = $this->repo->getById($sectionId);

		$form = $this->formRepo->getByKey($formKey);

		$this->authorize('remove', $section, "You do not have permission to remove form sections.");

		$section = $this->repo->delete($section);

		event(new Events\FormFieldWasDeleted($section->id, $section->name, $form->key));

		flash()->success("Form Section Removed!");

		return redirect()->route('admin.forms.sections', [$formKey]);
	}

	public function updateFieldOrder()
	{
		$this->isAjax = true;

		$section = new NovaFormSection;

		if (policy($section)->edit($this->user, $section))
		{
			foreach (request('sections') as $order => $id)
			{
				$updatedSection = $this->repo->updateOrder($id, $order);

				event(new Events\FormFieldOrderWasUpdated($updatedSection));
			}
		}
	}

}
