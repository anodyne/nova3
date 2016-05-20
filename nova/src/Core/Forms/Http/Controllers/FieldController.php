<?php namespace Nova\Core\Forms\Http\Controllers;

use NovaFormField,
	BaseController,
	FormRepositoryContract,
	RoleRepositoryContract,
	FormTabRepositoryContract,
	FormFieldRepositoryContract,
	FormSectionRepositoryContract,
	EditFormFieldRequest, CreateFormFieldRequest, RemoveFormFieldRequest;

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

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;
		$this->tabRepo = $tabs;
		$this->formRepo = $forms;
		$this->roleRepo = $roles;
		$this->sectionRepo = $sections;

		$this->middleware('auth');
	}

	public function all($formKey)
	{
		$field = $this->data->field = new NovaFormField;

		$this->authorize('manage', $field, "You do not have permission to manage form fields.");

		$this->views->put('page', 'admin/forms/fields');
		$this->views->put('scripts' [
			'Sortable.min',
			'admin/forms/fields',
		]);
		$this->views->put('styles', ['uikit/components/icon']);

		$form = $this->data->form = $this->formRepo->getByKey($formKey, ['fieldsUnboundAll', 'fieldsUnboundAll.data', 'fieldsUnboundAll.data.field', 'sectionsUnboundAll', 'sectionsUnboundAll.fieldsAll', 'sectionsUnboundAll.fieldsAll.data', 'sectionsUnboundAll.fieldsAll.data.field', 'parentTabsAll', 'parentTabsAll.fieldsUnboundAll', 'parentTabsAll.fieldsUnboundAll.data', 'parentTabsAll.fieldsUnboundAll.data.field', 'parentTabsAll.sectionsAll', 'parentTabsAll.sectionsAll.fieldsAll', 'parentTabsAll.sectionsAll.fieldsAll.data', 'parentTabsAll.sectionsAll.fieldsAll.data.field', 'parentTabsAll.childrenTabsAll.fieldsUnboundAll', 'parentTabsAll.childrenTabsAll.fieldsUnboundAll.data', 'parentTabsAll.childrenTabsAll.fieldsUnboundAll.data.field', 'parentTabsAll.childrenTabsAll.sectionsAll', 'parentTabsAll.childrenTabsAll.sectionsAll.fieldsAll', 'parentTabsAll.childrenTabsAll.sectionsAll.fieldsAll.data', 'parentTabsAll.childrenTabsAll.sectionsAll.fieldsAll.data.field']);

		$this->data->unboundFields = $this->formRepo->getUnboundFields($form, [], true);
		$this->data->unboundSections = $this->formRepo->getUnboundSections($form, [], true);
		$this->data->parentTabs = $this->formRepo->getParentTabs($form, [], true);

		$this->data->orderUpdateUrl = route('admin.forms.fields.updateOrder');
	}

	public function create($formKey)
	{
		$this->authorize('create', new NovaFormField, "You do not have permission to create form fields.");

		$this->views->put('page', 'admin/forms/field-create');
		$this->views->put('scripts', [
			'Sortable.min',
			'admin/forms/field-create',
		]);
		$this->views->put('styles', ['uikit/components/icon']);

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

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

		$this->data->accessRoles = $this->roleRepo->listAll('name', 'key');

		$fieldTypes = $this->getFieldTypes();
		$this->data->fieldTypes = $fieldTypes->get('types');
		$this->data->fieldTypesArr = $fieldTypes->get('array');
	}

	public function store(CreateFormFieldRequest $request, $formKey)
	{
		$this->authorize('create', new NovaFormField, "You do not have permission to create form fields.");

		$field = $this->repo->create($request->all());

		flash()->success("Form Field Created!");

		return redirect()->route('admin.forms.fields', [$formKey]);
	}

	public function edit($formKey, $fieldId)
	{
		$field = $this->data->field = $this->repo->getById($fieldId);

		$this->authorize('edit', $field, "You do not have permission to edit form fields.");

		$this->views->put('page', 'admin/forms/field-edit');
		$this->views->put('scripts', [
			'Sortable.min',
			'admin/forms/field-edit',
		]);
		$this->views->put('styles', ['uikit/components/icon']);

		$form = $this->data->form = $this->formRepo->getByKey($formKey);

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

		$this->data->accessRoles = $this->roleRepo->listAll('name', 'key');

		$fieldTypes = $this->getFieldTypes();
		$this->data->fieldTypes = $fieldTypes->get('types');
		$this->data->fieldTypesArr = $fieldTypes->get('array');
		
		$this->data->attributes = ($field->attributes) ? $field->attributes->toArray() : null;
		$this->data->restrictions = ($field->restrictions) ? $field->restrictions->toArray() : null;
		$this->data->validationRules = ($field->validation_rules) ? $field->validation_rules->toArray() : null;
		$this->data->values = ($field->values) ? $field->values->toArray() : null;
	}

	public function update(EditFormFieldRequest $request, $formKey, $fieldId)
	{
		$this->authorize('edit', new NovaFormField, "You do not have permission to edit form fields.");

		$field = $this->repo->update($fieldId, $request->all());

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
		$this->authorize('remove', new NovaFormField, "You do not have permission to remove form fields.");

		$field = $this->repo->delete($fieldId);

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
		$fieldTypes->put('array', $typesJson);

		return $fieldTypes;
	}

}
