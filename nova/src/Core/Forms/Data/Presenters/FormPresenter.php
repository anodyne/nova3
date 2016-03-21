<?php namespace Nova\Core\Forms\Data\Presenters;

use Form, HTML, Status;
use Laracasts\Presenter\Presenter;

class FormPresenter extends Presenter {

	public function hasHorizontalOrientation()
	{
		return $this->entity->orientation == 'horizontal';
	}

	public function hasVerticalOrientation()
	{
		return $this->entity->orientation == 'vertical';
	}

	public function renderViewForm($id)
	{
		$relations = [
			'fieldsUnbound', 
			'sectionsUnbound', 'sectionsUnbound.fields', 
			'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.sections', 'parentTabs.sections.fields', 
			'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields',
			//'data', 'data.field',
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = $this->createFormOpenTag('view');
		$formCloseTag = $this->createFormCloseTag('view');

		// Grab the data for the item we're viewing
		$data = $form->data->where('data_id', $id);

		// Set the action we're taking
		$action = 'view';

		return partial('form-static', compact('form', 'formOpenTag', 'formCloseTag', 'data', 'action'));
	}

	public function renderNewForm($includeFormTags = true, $includeButton = true)
	{
		$relations = [
			'fieldsUnbound', 
			'sectionsUnbound', 'sectionsUnbound.fields', 
			'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.sections', 'parentTabs.sections.fields', 
			'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields',
			//'data', 'data.field'
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

		return partial('form-editable', compact('form', 'formOpenTag', 'formCloseTag', 'data', 'action', 'includeButton'));
	}

	public function renderEditForm($id, $includeFormTags = true, $includeButton = true)
	{
		$relations = [
			'fieldsUnbound', 
			'sectionsUnbound', 'sectionsUnbound.fields', 
			'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.sections', 'parentTabs.sections.fields', 
			'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields',
			//'data', 'data.field',
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = ($includeFormTags) 
			? $this->createFormOpenTag('edit') 
			: $this->createFormOpenTag('view');
		$formCloseTag = ($includeFormTags) 
			? $this->createFormCloseTag('edit') 
			: $this->createFormCloseTag('view');

		// Grab the data for the item we're editing
		$data = $form->data->where('data_id', $id);

		// Set the action we're taking
		$action = 'edit';

		return partial('form-editable', compact('form', 'formOpenTag', 'formCloseTag', 'data', 'action', 'includeButton'));
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

	protected function createFormOpenTag($type)
	{
		$attributes = [];

		if ($this->hasHorizontalOrientation())
		{
			$attributes['class'] = 'form-horizontal';
		}

		if ($type == 'create')
		{
			//$attributes['route'] = $this->entity->resource_create;
		}

		if ($type == 'edit')
		{
			//$attributes['route'] = $this->entity->resource_update;
			$attributes['method'] = 'put';
		}

		if ($type == 'view')
		{
			return '<div'.HTML::attributes($attributes).'>';
		}

		return Form::open($attributes);
	}

}
