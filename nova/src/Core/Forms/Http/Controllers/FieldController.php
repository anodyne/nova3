<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaFormField,
	BaseController,
	FormRepositoryContract,
	RoleRepositoryContract,
	FormTabRepositoryContract,
	FormFieldRepositoryContract,
	FormSectionRepositoryContract,
	EditFormFieldRequest, CreateFormFieldRequest, RemoveFormFieldRequest;
use Nova\Core\Forms\Events;

class FieldController extends BaseController {

	protected $repo;
	protected $tabRepo;
	protected $formRepo;
	protected $roleRepo;
	protected $sectionRepo;

	public function __construct(FormFieldRepositoryContract $repo,
			FormSectionRepositoryContract $sections, 
			FormRepositoryContract $forms,
			FormTabRepositoryContract $tabs,
			RoleRepositoryContract $roles)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->tabRepo = $tabs;
		$this->formRepo = $forms;
		$this->roleRepo = $roles;
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

		$form = $this->data->form = $this->formRepo->getByKey($formKey, ['fieldsUnboundAll', 'fieldsUnboundAll.data', 'fieldsUnboundAll.data.field', 'sectionsUnboundAll', 'sectionsUnboundAll.fieldsAll', 'sectionsUnboundAll.fieldsAll.data', 'sectionsUnboundAll.fieldsAll.data.field', 'parentTabsAll', 'parentTabsAll.fieldsUnboundAll', 'parentTabsAll.fieldsUnboundAll.data', 'parentTabsAll.fieldsUnboundAll.data.field', 'parentTabsAll.sectionsAll', 'parentTabsAll.sectionsAll.fieldsAll', 'parentTabsAll.sectionsAll.fieldsAll.data', 'parentTabsAll.sectionsAll.fieldsAll.data.field', 'parentTabsAll.childrenTabsAll.fieldsUnboundAll', 'parentTabsAll.childrenTabsAll.fieldsUnboundAll.data', 'parentTabsAll.childrenTabsAll.fieldsUnboundAll.data.field', 'parentTabsAll.childrenTabsAll.sectionsAll', 'parentTabsAll.childrenTabsAll.sectionsAll.fieldsAll', 'parentTabsAll.childrenTabsAll.sectionsAll.fieldsAll.data', 'parentTabsAll.childrenTabsAll.sectionsAll.fieldsAll.data.field']);

		$this->data->unboundFields = $this->formRepo->getUnboundFields($form, [], true);
		$this->data->unboundSections = $this->formRepo->getUnboundSections($form, [], true);
		$this->data->parentTabs = $this->formRepo->getParentTabs($form, [], true);
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
			'col-md-2' => "Extra Small",
			'col-md-4' => "Small",
			'col-md-6' => "Normal",
			'col-md-8' => "Medium",
			'col-md-10' => "Large",
			'col-md-12' => "Extra Large",
			'Custom' => "Custom",
		];

		$this->data->accessRoles = $this->roleRepo->listAll('display_name', 'name');

		$fieldTypes = $this->getFieldTypes();
		$this->data->fieldTypes = $fieldTypes->get('types');
		$this->jsData->fieldTypes = $fieldTypes->get('json');
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
			'col-md-2' => "Extra Small",
			'col-md-4' => "Small",
			'col-md-6' => "Normal",
			'col-md-8' => "Medium",
			'col-md-10' => "Large",
			'col-md-12' => "Extra Large",
			'Custom' => "Custom",
		];

		$this->data->accessRoles = $this->roleRepo->listAll('display_name', 'name');

		$fieldTypes = $this->getFieldTypes();
		$this->data->fieldTypes = $fieldTypes->get('types');

		$this->jsData->fieldTypes = $fieldTypes->get('json');
		$this->jsData->attributes = ($field->attributes) ? $field->attributes->toJson() : null;
		$this->jsData->restrictions = ($field->restrictions) ? $field->restrictions->toJson() : null;
		$this->jsData->validationRules = ($field->validation_rules) ? $field->validation_rules->toJson() : null;
		$this->jsData->values = ($field->values) ? $field->values->toJson() : null;
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

	public function remove($formKey, $fieldId)
	{
		$this->isAjax = true;

		$field = $this->repo->getById($fieldId);

		if ( ! $field)
		{
			$body = alert('danger', "Form field could not be found.");
		}
		else
		{
			$form = $this->formRepo->getByKey($formKey);

			$body = (policy($field)->remove($this->user, $field))
				? view(locate('page', 'admin/forms/field-remove'), compact('form', 'field'))
				: alert('danger', "You do not have permission to remove form fields.");
		}

		return partial('modal-content', [
			'header' => "Remove Form Field",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveFormFieldRequest $request, $formKey, $fieldId)
	{
		$field = $this->repo->getById($fieldId);

		$this->authorize('remove', $field, "You do not have permission to remove form fields.");

		$form = $this->formRepo->getByKey($formKey);

		$field = $this->repo->delete($field);

		event(new Events\FormFieldWasDeleted($field->id, $field->label, $form->key));

		flash()->success("Form Field Removed!");

		return redirect()->route('admin.forms.fields', [$formKey]);
	}

	public function updateFieldOrder()
	{
		$this->isAjax = true;

		$field = new NovaFormField;

		if (policy($field)->edit($this->user, $field))
		{
			foreach (request('fields') as $order => $id)
			{
				$updatedField = $this->repo->updateOrder($id, $order);

				event(new Events\FormFieldOrderWasUpdated($updatedField));
			}
		}
	}

	protected function getFieldTypes()
	{
		$fieldTypes = collect();
		$typesArr = [];
		$typesJson = [];

		app('nova.forms.fields')->getAllFieldTypes()->map(function ($type) use (&$typesArr, &$typesJson)
		{
			$info = $type->info();

			$typesArr[$info['value']] = $info['name'];

			$typesJson[$info['value']] = $info;
		});

		$fieldTypes->put('types', $typesArr);
		$fieldTypes->put('json', json_encode($typesJson));

		return $fieldTypes;
	}

}
