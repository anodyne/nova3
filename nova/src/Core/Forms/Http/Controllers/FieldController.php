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

		$form = $this->data->form = $this->formRepo->getByKey($formKey, ['fields', 'sections', 'sections.fields', 'tabs', 'tabs.fields', 'tabs.sections', 'tabs.sections.fields', 'tabs.childrenTabs', 'tabs.childrenTabs.fields', 'tabs.childrenTabs.sections', 'tabs.childrenTabs.sections.fields']);

		$this->data->unboundFields = $this->formRepo->getUnboundFields($form);

		$this->data->unboundSections = $this->formRepo->getUnboundSections($form);

		$this->data->tabs = $this->formRepo->getTabs($form);
	}

	public function create($formKey)
	{
		$this->authorize('create', new NovaFormField, "You do not have permission to create form fields.");

		$this->view = 'admin/forms/field-create';
		$this->jsView = 'admin/forms/field-create-js';
		$this->styleView = 'admin/forms/field-create-style';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->types = [
			'text' => "Text field",
			'textarea' => "Text block",
			'select' => "Dropdown menu",
			'radio' => "Radio buttons"
		];

		$this->data->tabs = ['0' => "No tab"];
		$this->data->tabs+= $this->tabRepo->listAll('name', 'id');

		$this->data->sections = ['0' => "No section"];
		$this->data->sections+= $this->sectionRepo->listAll('name', 'id');

		$this->data->sizes = [
			'col-md-2' => "Small",
			'col-md-4' => "Medium",
			'col-md-6' => "Normal",
			'col-md-8' => "Large",
			'col-md-10' => "Extra Large",
			'col-md-12' => "Huge",
			'Custom' => "Custom",
		];
	}

	public function store(CreateFormFieldRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormField, "You do not have permission to create form fields.");

		$field = $this->repo->create($request->all());

		event(new Events\FormFieldWasCreated($field));

		flash()->success("Form Field Created!");

		return redirect()->route('admin.forms.fields', [$formKey]);
	}

	public function edit($formKey, $fieldId)
	{
		$field = $this->data->field = $this->repo->getById($fieldId);

		$this->authorize('edit', $field, "You do not have permission to edit form fields.");

		$this->view = 'admin/forms/field-edit';
		$this->jsView = 'admin/forms/field-edit-js';
		$this->styleView = 'admin/forms/field-edit-style';

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

		$this->data->types = [
			'text' => "Text field",
			'textarea' => "Text block",
			'select' => "Dropdown menu",
			'radio' => "Radio buttons"
		];

		$this->data->tabs = ['0' => "No tab"];
		$this->data->tabs+= $this->tabRepo->listAll('name', 'id');

		$this->data->sections = ['0' => "No section"];
		$this->data->sections+= $this->sectionRepo->listAll('name', 'id');

		$this->data->sizes = [
			'col-md-2' => "Small",
			'col-md-4' => "Medium",
			'col-md-6' => "Normal",
			'col-md-8' => "Large",
			'col-md-10' => "Extra Large",
			'col-md-12' => "Huge",
			'Custom' => "Custom",
		];
	}

	public function update(EditFormFieldRequest $request, $formKey, $fieldId)
	{
		$field = $this->repo->getById($fieldId);

		$this->authorize('edit', $field, "You do not have permission to edit form fields.");

		$field = $this->repo->update($field, $request->all());

		event(new Events\FormFieldWasUpdated($field));

		flash()->success("Form Field Updated!");

		return redirect()->route('admin.forms.fields', [$formKey]);
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
