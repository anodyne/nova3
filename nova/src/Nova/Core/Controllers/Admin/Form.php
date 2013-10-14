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

class Form extends AdminBaseController {

	public function __construct(FormRepositoryInterface $form)
	{
		parent::__construct();

		// Set the injected interface
		$this->form = $form;
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

			if ($formKey !== "0")
			{
				// Get the form
				$form = $this->data->form = $this->form->findByKey($formKey);

				// Get the form fields
				$this->data->formFields = $this->form->getFormFieldsForDropdown($formKey, 'id', 'label');
			}
			else
			{
				$this->data->form = false;
			}

			// Set the action
			$this->mode = $this->data->action = ($formKey === '0') ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/forms';

			// Get all the forms
			$form = $this->data->forms = $this->form->all();
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
				// Delete the form
				$this->form->delete(Input::get('id'));
			}
			catch (\FormProtectedException $e)
			{
				Session::flash('flashStatus', 'danger');
				Session::flash('flashMessage', lang('error.admin.protectedForm'));
			}
		}

		return Redirect::to('admin/form');
	}

	public function getTabs($formKey, $tabId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view files
		$this->view = 'admin/form/tabs';
		$this->jsView = 'admin/form/tabs_js';

		// Pass along the form key to the view
		$this->data->formKey = $formKey;

		// Get the form and pass it along to the view
		$form = $this->data->form = $this->form->findByKey($formKey);

		// Get the tabs
		$tabs = $form->tabs;

		// If there isn't an ID, show all the tabs
		if ($tabId === false)
		{
			// Set up the variables
			$this->data->tabs = false;

			if ($tabs->count() > 0)
			{
				// Sort the tabs
				$this->data->tabs = $tabs->sortBy(function($t)
				{
					return $t->order;
				});
			}
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/tabs_action';

			// Get the tab
			$tab = $this->data->tab = $form->tabs()->find($tabId);

			// ID 0 means a new tab, anything else edits an existing tab
			if ((int) $tabId === 0)
			{
				// Set the action
				$this->mode = $this->data->action = 'create';
			}
			else
			{
				// Set the action
				$this->mode = $this->data->action = 'update';

				// If we don't have a tab, redirect to the creation screen
				if ($this->data->tab === null)
				{
					Redirect::to("admin/form/tabs/{$formKey}/0");
				}

				// If the tab isn't part of this form, redirect them
				if ($tab->form->key != $formKey)
				{
					Redirect::to("admin/form/tabs/{$tab->form->key}/{$tabId}");
				}
			}
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

		// Set the view files
		$this->view = 'admin/form/sections';
		$this->jsView = 'admin/form/sections_js';

		// Pass along the form key to the view
		$this->data->formKey = $formKey;

		// Get the form and pass it along to the view
		$form = $this->data->form = $this->form->findByKey($formKey);

		// If there isn't an ID, show all the sections
		if ($sectionId === false)
		{
			// Get the form sections
			$sections = $form->sections;

			// Set up the variables
			$this->data->tabs = false;
			$this->data->sections = false;

			// If we have tabs, get them
			if ($form->tabs->count() > 0)
			{
				$this->data->tabs = $form->tabs->sortBy(function($t)
				{
					return $t->order;
				});
			}

			// If we have sections, get them
			if ($sections->count() > 0)
			{
				// Sort the sections
				$sections = $sections->sortBy(function($s)
				{
					return $s->order;
				});

				foreach ($sections as $section)
				{
					if ($section->tab_id > 0)
					{
						$this->data->sections[$section->tab_id][] = $section;
					}
					else
					{
						$this->data->sections[] = $section;
					}
				}
			}
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/sections_action';

			// Get all the tabs
			$tabs = $this->data->tabs = $form->tabs->toSimpleArray('id', 'name');

			// Get the section
			$section = $this->data->section = $form->sections()->find($sectionId);

			// ID 0 means a new section, anything else edits an existing section
			if ((int) $sectionId === 0)
			{
				// Set the action
				$this->mode = $this->data->action = 'create';
			}
			else
			{
				// Set the action
				$this->mode = $this->data->action = 'update';

				// If we don't have a section, redirect to the creation screen
				if ($this->data->section === null)
				{
					Redirect::to("admin/form/sections/{$formKey}/0");
				}

				// If the section isn't part of this form, redirect them
				if ($this->data->section->form->key != $formKey)
				{
					Redirect::to("admin/form/sections/{$section->form->key}/{$sectionId}");
				}
			}
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

		// Set the view files
		$this->view = 'admin/form/fields';
		$this->jsView = 'admin/form/fields_js';

		// Pass along the form key to the view
		$this->data->formKey = $formKey;

		// Get the form and pass it along
		$form = $this->data->form = $this->form->findByKey($formKey);

		// If there isn't an ID, show all the fields
		if ($fieldId === false)
		{
			// Setup the dynamic form and assemble the elements
			$formOutput = DynamicForm::setup($formKey, false, true);
			$formOutput->assemble();

			// Set up the variables
			$this->data->tabs = $formOutput->getData('tabs');
			$this->data->sections = $formOutput->getData('sections');
			$this->data->fields = $formOutput->getData('fields');
		}
		else
		{
			// Set the view
			$this->view = 'admin/form/fields_action';

			// Get the field
			$field = $this->data->field = $form->fields()->find($fieldId);

			// Set the field types
			$this->data->types = [
				'text'		=> lang('Text_field'),
				'textarea'	=> lang('Text_area'),
				'select'	=> lang('Dropdown'),
			];

			// Resolve the binding
			$role = Nova::resolveBinding('AccessRoleRepositoryInterface');

			// Set the access restrictions
			$this->data->accessRoles = $role->all();

			// Get the tabs and sections
			$this->data->tabs[0] = lang('short.selectOne', lang('tab'));
			$this->data->tabs+= $form->tabs->toSimpleArray('id', 'name');
			$this->data->sections[0] = lang('short.selectOne', lang('section'));
			$this->data->sections+= $form->sections->toSimpleArray('id', 'name');

			// Clear out the message for this page
			$this->data->message = false;

			// ID 0 means a new section, anything else edits an existing section
			if ((int) $fieldId === 0)
			{
				// Set the action
				$this->mode = $this->data->action = 'create';
			}
			else
			{
				// Set the action
				$this->mode = $this->data->action = 'update';

				// Get the field values
				$this->data->values = $field->values->sortBy(function($v)
				{
					return $v->order;
				});

				// If we don't have a field, redirect to the creation screen
				if ($field === null)
				{
					Redirect::to("admin/form/fields/{$formKey}/0");
				}

				// If the field isn't part of this form, redirect them
				if ($field->form->key != $formKey)
				{
					Redirect::to("admin/form/fields/{$field->form->key}/{$fieldId}");
				}
			}
		}
	}
	public function postFields($formKey)
	{
		// Get the action
		$formAction = e(Input::get('formAction'));

		// Set up the validation service
		$validator = new FormFieldValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($formAction == 'delete')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to("admin/form/fields/{$formKey}")
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}
			
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

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
			$this->form->deleteField(Input::get('id'), $form);

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