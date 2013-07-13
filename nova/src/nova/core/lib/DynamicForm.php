<?php namespace Nova\Core\Lib;

use View;
use NovaForm;
use NovaFormData;
use Utility as UtilityLib;
use Location as LocationLib;

class DynamicForm {
	
	/**
	 * The form key.
	 */
	protected $formKey;

	/**
	 * The form object.
	 */
	protected $form;

	/**
	 * Entry ID.
	 */
	protected $id;

	/**
	 * Data for the form to use.
	 */
	protected $data = [];

	/**
	 * Setup for building the form.
	 *
	 * @param	string	Form key
	 * @param	int		Entry ID
	 * @param	bool	Editable or not
	 * @return	DynamicForm
	 */
	public function setup($formKey, $id = false, $editable = true)
	{
		$this->formKey = $formKey;
		$this->form = $this->data['form'] = NovaForm::key($formKey)->first();
		$this->id = $this->data['id'] = $id;
		$this->data['editable'] = $editable;

		return $this;
	}

	/**
	 * Assemble the elements for the form.
	 *
	 * @return	void
	 */
	public function assemble()
	{
		// Assemble the tabs
		$this->data['tabs'] = $this->assembleTabs($this->form);

		// Assemble the sections
		$this->data['sections'] = $this->assembleSections($this->form);

		// Assemble the fields
		$this->data['fields'] = $this->assembleFields($this->form);
	}

	/**
	 * Build the form.
	 *
	 * @return	string
	 */
	public function build()
	{
		// Assemble the elements
		$this->assemble();

		return View::make(LocationLib::file('forms/form', UtilityLib::getSkin(), 'partial'), $this->data);
	}

	/**
	 * Grab the data for the dynamic form.
	 *
	 * @param	object	Data object
	 * @param	int		Field ID
	 * @return	string|bool
	 */
	public function displayData($obj, $i)
	{
		if (is_array($obj) and is_object($obj[$i]))
		{
			return $obj[$i]->value;
		}

		return false;
	}

	/**
	 * Get the assembled data.
	 *
	 * @param	string	Type of data to retrieve
	 * @return	array
	 */
	public function getData($type = false)
	{
		if ($type)
		{
			return $this->data[$type];
		}

		return $this->data;
	}

	/**
	 * Pull together all the tab data.
	 *
	 * @param	Collection	Form collection
	 * @return	array
	 */
	protected function assembleTabs($form)
	{
		$final = [];

		if ($form->tabs->count() > 0)
		{
			foreach ($form->tabs as $tab)
			{
				$final[] = [
					'tab'		=> $tab,
					'sections'	=> $tab->sections,
					'fields'	=> $tab->fields,
					'data'		=> $this->assembleData($tab->form->fields),
				];
			}
		}

		return $final;
	}

	/**
	 * Pull together all the section data.
	 *
	 * @param	Collection	Form collection
	 * @return	array
	 */
	protected function assembleSections($form)
	{
		$final = [];

		if ($form->tabs->count() == 0 and $form->sections->count() > 0)
		{
			foreach ($form->sections as $section)
			{
				$final[] = [
					'section'	=> $section,
					'fields'	=> $section->fields,
					'data'		=> $this->assembleData($section->form->fields),
				];
			}
		}

		return $final;
	}

	/**
	 * Pull together all the field data.
	 *
	 * @param	Collection	Form collection
	 * @return	array
	 */
	protected function assembleFields($form)
	{
		$final = [];

		if ($form->tabs->count() == 0 
				and $form->sections->count() == 0 
				and $form->fields->count() > 0)
		{
			foreach ($form->fields as $field)
			{
				$final[] = [
					'field'	=> $field,
					'data'	=> $this->assembleData($field->form->fields),
				];
			}
		}

		return $final;
	}

	/**
	 * Pull together all the entry data.
	 *
	 * @param	Collection	A collection of all the fields
	 * @return	array
	 */
	protected function assembleData($fields)
	{
		$final = [];

		if ($fields->count() > 0)
		{
			foreach ($fields as $field)
			{
				$final[$field->id] = NovaFormData::key($field->form->key)
					->entry($this->id)
					->formField($field->id)
					->first();
			}
		}

		return $final;
	}

}