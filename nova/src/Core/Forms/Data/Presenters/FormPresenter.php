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
			//'fieldsUnbound.values', 'sectionsUnbound.fields.values', 'parentTabs.fieldsUnbound.values',
			//'parentTabs.sections.fields.values', 'parentTabs.childrenTabs.fieldsUnbound.values',
			//'parentTabs.childrenTabs.sections.fields.values', 'data', 'data.field',
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = $this->createFormOpenTag('view');
		$formCloseTag = $this->createFormCloseTag('view');

		// Grab the data for the item we're viewing
		$data = $form->data->where('data_id', $id);

		return partial('form-static', compact('form', 'formOpenTag', 'formCloseTag', 'data'));
	}

	public function renderNewForm()
	{
		$relations = [
			'fieldsUnbound', 
			'sectionsUnbound', 'sectionsUnbound.fields', 
			'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.sections', 'parentTabs.sections.fields', 
			'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields',
			//'fieldsUnbound.values', 'sectionsUnbound.fields.values', 'parentTabs.fieldsUnbound.values',
			//'parentTabs.sections.fields.values', 'parentTabs.childrenTabs.fieldsUnbound.values',
			//'parentTabs.childrenTabs.sections.fields.values', 'data', 'data.field'
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = $this->createFormOpenTag('create');
		$formCloseTag = $this->createFormCloseTag('create');

		// Keep an empty collection for the data
		$data = collect();

		return partial('form-editable', compact('form', 'formOpenTag', 'formCloseTag', 'data'));
	}

	public function renderEditForm($id)
	{
		$relations = [
			'fieldsUnbound', 
			'sectionsUnbound', 'sectionsUnbound.fields', 
			'parentTabs', 'parentTabs.fieldsUnbound', 'parentTabs.sections', 'parentTabs.sections.fields', 
			'parentTabs.childrenTabs', 'parentTabs.childrenTabs.fieldsUnbound', 'parentTabs.childrenTabs.sections', 'parentTabs.childrenTabs.sections.fields',
			//'fieldsUnbound.values', 'sectionsUnbound.fields.values', 'parentTabs.fieldsUnbound.values',
			//'parentTabs.sections.fields.values', 'parentTabs.childrenTabs.fieldsUnbound.values',
			//'parentTabs.childrenTabs.sections.fields.values', 'data', 'data.field',
		];

		// Grab the form and eager load all the relations
		$form = $this->entity->load($relations);

		// Build the opening/closing tags
		$formOpenTag = $this->createFormOpenTag('edit');
		$formCloseTag = $this->createFormCloseTag('edit');

		// Grab the data for the item we're editing
		$data = $form->data->where('data_id', $id);

		return partial('form-editable', compact('form', 'formOpenTag', 'formCloseTag', 'data'));
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
