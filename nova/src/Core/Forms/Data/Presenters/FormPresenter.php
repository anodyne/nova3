<?php namespace Nova\Core\Forms\Data\Presenters;

use Form,
	HTML,
	Status,
	Markdown,
	BasePresenter;

class FormPresenter extends BasePresenter {

	public function hasHorizontalOrientation()
	{
		return $this->entity->orientation == 'horizontal';
	}

	public function hasVerticalOrientation()
	{
		return $this->entity->orientation == 'vertical';
	}

	public function message()
	{
		return Markdown::parse($this->entity->message);
	}

	public function renderViewForm($id)
	{
		$relations = [
			'fieldsUnbound', 'fieldsUnbound.data', 'sectionsUnbound', 'sectionsUnbound.fields', 'sectionsUnbound.fields.data', 'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.fieldsUnbound.data', 'parentTabs.sections', 'parentTabs.sections.fields', 'parentTabs.sections.fields.data', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.fieldsUnbound.data', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields', 'parentTabs.childrenTabs.sections.fields.data', 'data', 'data.field'
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = $this->createFormOpenTag('view');
		$formCloseTag = $this->createFormCloseTag('view');

		// Grab the data for the item we're viewing
		$data = $form->data->whereLoose('entry_id', $id);

		// Set the action we're taking
		$action = 'view';

		return partial('form/form-static', compact('form', 'formOpenTag', 'formCloseTag', 'data', 'action', 'id'));
	}

	public function renderNewForm($includeFormTags = true, $includeButton = true, $fieldNameWrapper = null)
	{
		$relations = [
			'fieldsUnbound', 'fieldsUnbound.data', 'sectionsUnbound', 'sectionsUnbound.fields', 'sectionsUnbound.fields.data', 'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.fieldsUnbound.data', 'parentTabs.sections', 'parentTabs.sections.fields', 'parentTabs.sections.fields.data', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.fieldsUnbound.data', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields', 'parentTabs.childrenTabs.sections.fields.data', 'data', 'data.field'
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = ($includeFormTags) 
			? $this->createFormOpenTag('create') 
			: $this->createFormOpenTag('view');
		$formCloseTag = ($includeFormTags) 
			? $this->createFormCloseTag('create') 
			: $this->createFormCloseTag('view');

		// Keep an empty collection for the data
		$data = collect();

		// Set the action we're taking
		$action = 'create';

		$id = null;

		return partial('form/form-editable', compact('form', 'formOpenTag', 'formCloseTag', 'data', 'action', 'includeButton', 'id', 'fieldNameWrapper'));
	}

	public function renderEditForm($id, $includeFormTags = true, $includeButton = true, $fieldNameWrapper = null)
	{
		$relations = [
			'fieldsUnbound', 'fieldsUnbound.data', 'sectionsUnbound', 'sectionsUnbound.fields', 'sectionsUnbound.fields.data', 'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.fieldsUnbound.data', 'parentTabs.sections', 'parentTabs.sections.fields', 'parentTabs.sections.fields.data', 'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.fieldsUnbound.data', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields', 'parentTabs.childrenTabs.sections.fields.data', 'data', 'data.field'
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = ($includeFormTags) 
			? $this->createFormOpenTag('edit', $id) 
			: $this->createFormOpenTag('view');
		$formCloseTag = ($includeFormTags) 
			? $this->createFormCloseTag('edit') 
			: $this->createFormCloseTag('view');

		// Grab the data for the item we're editing
		$data = $form->data->whereLoose('entry_id', $id);

		// Set the action we're taking
		$action = 'edit';

		return partial('form/form-editable', compact('form', 'formOpenTag', 'formCloseTag', 'data', 'action', 'includeButton', 'id', 'fieldNameWrapper'));
	}

	public function statusAsLabel()
	{
		if ($this->entity->status != Status::ACTIVE)
		{
			return label('danger', ucwords(Status::toString($this->entity->status)));
		}
	}

	protected function createFormCloseTag($type)
	{
		switch ($type)
		{
			case 'create':
			case 'edit':
				return Form::close();
			break;

			case 'view':
			default:
				return '</div>';
			break;
		}
	}

	protected function createFormOpenTag($type, $id = null)
	{
		$attributes = [];

		if ($this->hasHorizontalOrientation())
		{
			$attributes['class'] = 'form-horizontal';
		}

		if ($type == 'create')
		{
			$attributes['route'] = [$this->entity->resource_store, $this->entity->key];
		}

		if ($type == 'edit')
		{
			$attributes['route'] = [$this->entity->resource_update, $this->entity->key, $id];
			$attributes['method'] = 'put';
		}

		if ($type == 'view')
		{
			return '<div'.HTML::attributes($attributes).'>';
		}

		return Form::open($attributes);
	}

}
