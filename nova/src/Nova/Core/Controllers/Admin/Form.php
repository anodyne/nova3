<?php namespace Nova\Core\Controllers\Admin;

use Nova;
use View;
use Input;
use Session;
use Location;
use Redirect;
use DynamicForm;
use FormValidator;
use FormTabValidator;
use FormFieldValidator;
use FormValueValidator;
use AdminBaseController;
use FormSectionValidator;
use FormRepositoryInterface;
use AccessRoleRepositoryInterface;

class Form extends AdminBaseController {

	public function __construct(FormRepositoryInterface $form,
								AccessRoleRepositoryInterface $role)
	{
		parent::__construct();

		// Set the injected interfaces
		$this->form = $form;
		$this->role = $role;
	}

	public function getForms($formKey = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the JS view
		$this->jsView = 'admin/form/forms_js';

		if ($formKey !== false)
		{
			// Set the view
			$this->view = 'admin/form/forms_action';

			if ($formKey !== '0')
			{
				// Get the form
				$this->data->form = $this->form->findByKey($formKey);

				// Get the form fields
				$this->data->formFields = $this->form->getFormFieldsForDropdown($formKey, 'id', 'label');
			}
			else
				$this->data->form = false;

			// Set the action and mode
			$this->mode = $this->data->action = ($formKey === '0') ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/forms';

			// Get all the forms
			$this->data->forms = $this->form->all();
		}
	}
	public function postForms($formKey = false)
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new FormValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		// Create the form
		if ($this->currentUser->hasAccess('form.create') and $formAction == 'create')
			$this->form->create(Input::all());

		// Update the form
		if ($this->currentUser->hasAccess('form.update') and $formAction == 'update')
			$this->form->update(Input::get('id'), Input::all());

		// Delete the form
		if ($this->currentUser->hasAccess('form.delete') and $formAction == 'delete')
		{
			try
			{
				$this->form->delete(Input::get('id'));
			}
			catch (\FormProtectedException $e)
			{
				Session::flash('flashStatus', 'danger');
				Session::flash('flashMessage', lang('error.admin.form.protected'));
			}
		}

		return Redirect::to('admin/form');
	}

	public function getTabs($formKey, $tabId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view
		$this->jsView = 'admin/form/tabs_js';

		// Pass along the form key to the view
		$this->data->formKey = $formKey;

		// Get the form and pass it along to the view
		$this->data->form = $this->form->findByKey($formKey);

		if ($tabId !== false)
		{
			// Set the view
			$this->view = 'admin/form/tabs_action';

			// Get the tab
			$tab = $this->data->tab = $this->form->findTab($tabId);

			// If we don't have a tab, redirect to the creation screen
			if ($tab === null and (int) $tabId > 0)
			{
				return Redirect::to("admin/form/tabs/{$formKey}/0")
					->with('flashStatus', 'warning')
					->with('flashMessage', lang('error.admin.form.itemNotFoundCreation', lang('tab')));
			}

			// If the tab isn't part of this form, redirect them
			if ( ! $this->form->checkItemForm($tab, $formKey))
			{
				return Redirect::to("admin/form/tabs/{$formKey}")
					->with('flashStatus', 'warning')
					->with('flashMessage', lang('error.admin.form.itemForm', lang('tab')));
			}

			// Set the action and mode
			$this->mode = $this->data->action = ((int) $tabId === 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/tabs';

			// Get the form's tabs
			$this->data->tabs = $this->form->getFormTabs($formKey);
		}
	}
	public function postTabs($formKey)
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new FormTabValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		// Get the form
		$form = $this->form->findByKey($formKey);

		// Create a tab
		if ($this->currentUser->hasAccess('form.create') and $formAction == 'create')
			$this->form->createTab(Input::all(), $form);

		// Update a tab
		if ($this->currentUser->hasAccess('form.update') and $formAction == 'update')
			$this->form->updateTab(Input::get('id'), Input::all());

		// Delete a tab
		if ($this->currentUser->hasAccess('form.delete') and $formAction == 'delete')
			$this->form->deleteTab(Input::get('id'), Input::get('new_tab_id'));

		return Redirect::to("admin/form/tabs/{$formKey}");
	}

	public function getSections($formKey, $sectionId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view
		$this->jsView = 'admin/form/sections_js';

		// Pass along the form key to the view
		$this->data->formKey = $formKey;

		// Get the form and pass it along to the view
		$form = $this->data->form = $this->form->findByKey($formKey);

		if ($sectionId !== false)
		{
			// Set the view
			$this->view = 'admin/form/sections_action';

			// Get the section
			$section = $this->data->section = $this->form->findSection($sectionId);

			// Get all of the tabs for the dropdown
			$this->data->tabs = $this->form->getFormTabsForDropdown($formKey, 'id', 'name');

			// If we don't have a section, redirect to the creation screen
			if ($section === null and (int) $sectionId > 0)
			{
				return Redirect::to("admin/form/sections/{$formKey}/0")
					->with('flashStatus', 'warning')
					->with('flashMessage', lang('error.admin.form.itemNotFoundCreation', lang('section')));
			}

			// If the section isn't part of this form, redirect them
			if ( ! $this->form->checkItemForm($section, $formKey))
			{
				return Redirect::to("admin/form/sections/{$formKey}")
					->with('flashStatus', 'warning')
					->with('flashMessage', lang('error.admin.form.itemForm', lang('section')));
			}

			// Set the action and mode
			$this->mode = $this->data->action = ((int) $sectionId === 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/sections';

			// Get the form sections
			$this->data->sections = $this->form->getFormSectionsWithTabs($formKey);

			// Get the tabs
			$this->data->tabs = $this->form->getFormTabs($formKey);
		}
	}
	public function postSections($formKey)
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new FormSectionValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		// Get the form
		$form = $this->form->findByKey($formKey);

		// Create a section
		if ($this->currentUser->hasAccess('form.create') and $formAction == 'create')
			$this->form->createSection(Input::all(), $form);

		// Update a section
		if ($this->currentUser->hasAccess('form.update') and $formAction == 'update')
			$this->form->updateSection(Input::get('id'), Input::all());

		// Delete a section
		if ($this->currentUser->hasAccess('form.delete') and $formAction == 'delete')
			$this->form->deleteSection(Input::get('id'), Input::get('new_section_id'), $form);

		return Redirect::to("admin/form/sections/{$formKey}");
	}

	public function getFields($formKey, $fieldId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view
		$this->jsView = 'admin/form/fields_js';

		// Pass along the form key to the view
		$this->data->formKey = $formKey;

		// Get the form and pass it along
		$this->data->form = $this->form->findByKey($formKey);

		if ($fieldId !== false)
		{
			// Set the view
			$this->view = 'admin/form/fields_action';

			// Get the field
			$field = $this->data->field = $this->form->findField($fieldId);

			// Get the roles to allow setting access restrictions
			$this->data->accessRoles = $this->role->all();

			// Get the tabs and sections
			$this->data->tabs = $this->form->getFormTabsForDropdown($formKey, 'id', 'name');
			$this->data->sections = $this->form->getFormSectionsForDropdown($formKey, 'id', 'name');

			// Get the field's values
			$this->data->values = $this->form->getFormFieldValues($field);

			// If we don't have a field, redirect to the creation screen
			if ($field === null and (int) $fieldId > 0)
			{
				return Redirect::to("admin/form/fields/{$formKey}/0")
					->with('flashStatus', 'warning')
					->with('flashMessage', lang('error.admin.form.itemNotFoundCreation', lang('field')));
			}

			// If the field isn't part of this form, redirect them
			if ( ! $this->form->checkItemForm($field, $formKey))
			{
				return Redirect::to("admin/form/fields/{$formKey}")
					->with('flashStatus', 'warning')
					->with('flashMessage', lang('error.admin.form.itemForm', lang('field')));
			}

			// Set the action and mode
			$this->mode = $this->data->action = ((int) $fieldId === 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/fields';

			// Setup the dynamic form and assemble the elements
			$formOutput = DynamicForm::setup($formKey, false, true);
			$formOutput->assemble();

			// Set up the variables
			$this->data->tabs = $formOutput->getData('tabs');
			$this->data->sections = $formOutput->getData('sections');
			$this->data->fields = $formOutput->getData('fields');
		}
	}
	public function postFields($formKey)
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new FormFieldValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		// Get the form
		$form = $this->form->findByKey($formKey);

		// Create a form field
		if ($this->currentUser->hasAccess('form.create') and $formAction == 'create')
			$this->form->createField(Input::all(), $form);

		// Update a form field
		if ($this->currentUser->hasAccess('form.update') and $formAction == 'update')
			$this->form->updateField(Input::get('id'), Input::all());

		// Delete a form field
		if ($this->currentUser->hasAccess('form.delete') and $formAction == 'delete')
			$this->form->deleteField(Input::get('id'));

		return Redirect::to("admin/form/fields/{$formKey}");
	}

	public function postAjaxAddFormValue()
	{
		if ($this->currentUser->hasAccess('form.update'))
		{
			// Create the field value
			$item = $this->form->createFieldValue(Input::all(), Input::get('form'), Input::get('field'));

			if ($item)
			{
				return partial('forms/field_value', [
					'value'	=> $item->value,
					'id'	=> $item->id,
					'icons'	=> Nova::getIconIndex($this->skin),
				]);
			}
		}
	}

	public function getAjaxDeleteForm($formKey)
	{
		if ($this->currentUser->hasAccess('form.delete'))
		{
			// Get the form
			$form = $this->form->findByKey($formKey);

			// Only present the modal if we're allowed to delete it
			if ($form and (bool) $form->protected === false)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', lang('Form')),
					'modalBody'		=> View::make(Location::ajax('delete/form'))
										->with('form', $form),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	public function getAjaxDeleteFormField($id)
	{
		if ($this->currentUser->hasAccess('form.delete'))
		{
			// Get the field we're deleting
			$field = $this->form->findField($id);

			if ($field)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', langConcat('Form Field')),
					'modalBody'		=> View::make(Location::ajax('delete/field'))
										->with('name', $field->label)
										->with('id', $field->id)
										->with('formKey', $field->form->key),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	public function getAjaxDeleteFormSection($id)
	{
		if ($this->currentUser->hasAccess('form.delete'))
		{
			// Get the section we're deleting
			$section = $this->form->findSection($id);

			if ($section)
			{
				// Get all the sections
				$sections = $this->form->getFormSectionsForDropdown($section->form->key, 'id', 'name');

				// Remove the section we are deleting
				unset($sections[$id]);

				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', langConcat('Form Section')),
					'modalBody'		=> View::make(Location::ajax('delete/section'))
										->with('name', $section->name)
										->with('id', $section->id)
										->with('fields', $section->fields->count())
										->with('sections', $sections)
										->with('formKey', $section->form->key),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	public function getAjaxDeleteFormTab($id)
	{
		if ($this->currentUser->hasAccess('form.delete'))
		{
			// Get the tab we're deleting
			$tab = $this->form->findTab($id);

			if ($tab)
			{
				// Get all the tabs
				$tabs = $this->form->getFormTabsForDropdown($tab->form->key, 'id', 'name');

				// Remove the tab we're deleting
				unset($tabs[$id]);

				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', langConcat('Form Tab')),
					'modalBody'		=> View::make(Location::ajax('delete/tab'))
										->with('name', $tab->name)
										->with('id', $tab->id)
										->with('tabs', $tabs)
										->with('formKey', $tab->form->key),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	public function postAjaxDeleteFormValue()
	{
		if ($this->currentUser->hasAccess('form.delete'))
			$this->form->deleteFieldValue(Input::get('id'));

		return '';
	}

	public function postAjaxUpdateFormFieldOrder()
	{
		if ($this->currentUser->hasAccess('form.update'))
		{
			foreach (Input::get('field') as $key => $value)
			{
				$this->form->updateField($value, ['order' => $key + 1], false);
			}
		}

		return '';
	}

	public function postAjaxUpdateFormSectionOrder()
	{
		if ($this->currentUser->hasAccess('form.update'))
		{
			foreach (Input::get('section') as $key => $value)
			{
				$this->form->updateSection($value, ['order' => $key + 1], false);
			}
		}

		return '';
	}

	public function postAjaxUpdateFormTabOrder()
	{
		if ($this->currentUser->hasAccess('form.update'))
		{
			foreach (Input::get('tab') as $key => $value)
			{
				$this->form->updateTab($value, ['order' => $key + 1], false);
			}
		}

		return '';
	}

	public function postAjaxUpdateFormValue($type)
	{
		if ($this->currentUser->hasAccess('form.update'))
		{
			switch ($type)
			{
				case 'order':
					foreach (Input::get('value') as $key => $value)
					{
						$this->form->updateFieldValue($value, ['order' => $key + 1]);
					}
				break;
				
				case 'value':
				default:
					$this->form->updateFieldValue(Input::get('id'), ['value' => Input::get('value')]);
				break;
			}
		}

		return '';
	}

}