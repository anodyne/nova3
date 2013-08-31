<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use NovaForm;
use Redirect;
use DynamicForm;
use AdminBaseController;
use FormValidator;
use FormTabValidator;
use FormFieldValidator;
use FormValueValidator;
use FormSectionValidator;

class Form extends AdminBaseController {

	public function getIndex($formKey = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/form/forms_js';

		if ($formKey !== false)
		{
			// Set the view
			$this->_view = 'admin/form/forms_action';

			if ($formKey !== "0")
			{
				// Get the form
				$form = $this->_data->form = NovaForm::key($formKey)->first();

				// Get the form fields
				$this->_data->formFields[0] = lang('short.selectOne', langConcat('form field'));
				$this->_data->formFields+= $form->fields()
					->active()
					->orderAsc('label')
					->get()
					->toSimpleArray('id', 'label');
			}
			else
			{
				$this->_data->form = false;
			}

			// Set the action
			$this->_mode = $this->_data->action = ($formKey === '0') ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->_view = 'admin/form/forms';

			// Get all the forms
			$form = $this->_data->forms = NovaForm::all();

			// Build the delete form modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteForm')
				->with('modalHeader', lang('Short.delete', lang('Form')))
				->with('modalBody', false)
				->with('modalFooter', false);
		}
	}
	public function postIndex($formKey = false)
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		// Set up the validation service
		$validator = new FormValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			// Set the flash message
			$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
			$flashMessage.= implode(' ', $validator->getErrors()->all());

			return Redirect::to('admin/form')
				->with('flashStatus', 'danger')
				->with('flashMessage', $flashMessage);
		}

		/**
		 * Create the form.
		 */
		if ($user->hasAccess('form.create') and $action == 'create')
		{
			// Create the form
			$form = NovaForm::create(Input::all());

			// Set the flash info
			$flashStatus = ($form) ? 'success' : 'danger';
			$flashMessage = ($form) 
				? lang('Short.alert.success.create', lang('form'))
				: lang('Short.alert.failure.create', lang('form'));
		}

		/**
		 * Update the form.
		 */
		if ($user->hasAccess('form.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Update the form
				$form = NovaForm::find($id);
				$form->update(Input::all());
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? lang('Short.alert.success.update', lang('form'))
				: lang('Short.alert.failure.update', lang('form'));
		}

		/**
		 * Delete the form.
		 */
		if ($user->hasAccess('form.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the form
			$form = NovaForm::find($id);

			if ($form and ! $form->protected)
			{
				// Delete the form
				$item = $form->delete();

				// Set the flash info
				$flashStatus = 'success';
				$flashMessage = lang('Short.alert.success.delete', lang('form'));
			}
			else
			{
				// Form is protected
				$flashStatus = 'danger';
				$flashMessage = lang('error.admin.protectedForm');
			}
		}

		return Redirect::to('admin/form')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getTabs($formKey, $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view files
		$this->_view = 'admin/form/tabs';
		$this->_jsView = 'admin/form/tabs_js';

		// Pass along the form key to the view
		$this->_data->formKey = $formKey;

		// Get the form and pass it along to the view
		$form = $this->_data->form = NovaForm::key($formKey)->first();

		// Get the tabs
		$tabs = $form->tabs;

		// If there isn't an ID, show all the tabs
		if ($id === false)
		{
			// Set up the variables
			$this->_data->tabs = false;

			if ($tabs->count() > 0)
			{
				// Sort the tabs
				$tabs = $tabs->sortBy(function($t)
				{
					return $t->order;
				});

				foreach ($tabs as $tab)
				{
					$this->_data->tabs[] = $tab;
				}
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/form/tabs_action';

			// Get the tab
			$tab = $this->_data->tab = $form->tabs()->find($id);

			// Clear out the message for this page
			$this->_data->message = false;

			// ID 0 means a new tab, anything else edits an existing tab
			if ((int) $id === 0)
			{
				// Set the action
				$this->_mode = $this->_data->action = 'create';
			}
			else
			{
				// Set the action
				$this->_mode = $this->_data->action = 'update';

				// If we don't have a tab, redirect to the creation screen
				if ($this->_data->tab === null)
				{
					Redirect::to("admin/form/tabs/{$formKey}/0");
				}

				// If the tab isn't part of this form, redirect them
				if ($tab->form->key != $formKey)
				{
					Redirect::to("admin/form/tabs/{$tab->form->key}/{$id}");
				}
			}
		}

		// Build the delete tab modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'deleteTab')
			->with('modalHeader', lang('Short.delete', langConcat('Form Tab')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postTabs($formKey)
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		// Set up the validation service
		$validator = new FormTabValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($action == 'delete')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/form/tabs')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}
			
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the form
		$form = NovaForm::key($formKey)->first();

		/**
		 * Create a form tab.
		 */
		if ($user->hasAccess('form.create') and $action == 'create')
		{
			// Create the form tab
			$newTab = $form->tabs()->getModel()->newInstance(Input::all());
			$item = $form->tabs()->save($newTab);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('form tab'))
				: lang('Short.alert.failure.create', langConcat('form tab'));
		}

		/**
		 * Edit a form tab.
		 */
		if ($user->hasAccess('form.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Update the tab
			$tab = $form->tabs()->find($id);
			$item = $tab->update(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', langConcat('form tab'))
				: lang('Short.alert.failure.update', langConcat('form tab'));
		}

		/**
		 * Delete the form tab.
		 */
		if ($user->hasAccess('form.delete') and $action == 'delete')
		{
			// Get the tab ID we're deleting
			$id = e(Input::get('id'));

			// Get the new tab ID
			$newTabId = e(Input::get('new_tab_id'));

			// Get the tab we're deleting
			$tab = $form->tabs()->find($id);

			// Loop through the sections and update them
			foreach ($tab->sections as $section)
			{
				// Update the tab ID
				$section->tab_id = $newTabId;
				$section->save();
			}

			// Delete the tab
			$item = $tab->delete();

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.delete', langConcat('form tab'))
				: lang('Short.alert.failure.delete', langConcat('form tab'));
		}

		return Redirect::to("admin/form/tabs/{$formKey}")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getSections($formKey, $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view files
		$this->_view = 'admin/form/sections';
		$this->_jsView = 'admin/form/sections_js';

		// Pass along the form key to the view
		$this->_data->formKey = $formKey;

		// Get the form and pass it along to the view
		$form = $this->_data->form = NovaForm::key($formKey)->first();

		// If there isn't an ID, show all the sections
		if ($id === false)
		{
			// Get the form sections
			$sections = $form->sections;

			// Set up the variables
			$this->_data->tabs = false;
			$this->_data->sections = false;

			// If we have tabs, get them
			if ($form->tabs->count() > 0)
			{
				$this->_data->tabs = $form->tabs->sortBy(function($t)
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
						$this->_data->sections[$section->tab_id][] = $section;
					}
					else
					{
						$this->_data->sections[] = $section;
					}
				}
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/form/sections_action';

			// Get all the tabs
			$tabs = $this->_data->tabs = $form->tabs->toSimpleArray('id', 'name');

			// Get the section
			$section = $this->_data->section = $form->sections()->find($id);

			// Clear out the message for this page
			$this->_data->message = false;

			// ID 0 means a new section, anything else edits an existing section
			if ((int) $id === 0)
			{
				// Set the action
				$this->_mode = $this->_data->action = 'create';
			}
			else
			{
				// Set the action
				$this->_mode = $this->_data->action = 'update';

				// If we don't have a section, redirect to the creation screen
				if ($this->_data->section === null)
				{
					Redirect::to("admin/form/sections/{$formKey}/0");
				}

				// If the section isn't part of this form, redirect them
				if ($this->_data->section->form->key != $formKey)
				{
					Redirect::to("admin/form/sections/{$section->form->key}/{$id}");
				}
			}
		}

		// Build the delete section modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'deleteSection')
			->with('modalHeader', lang('Short.delete', langConcat('Form Section')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postSections($formKey)
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		// Set up the validation service
		$validator = new FormSectionValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($action == 'delete')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/form/sections')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}
			
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the form
		$form = NovaForm::key($formKey)->first();

		/**
		 * Create a form section.
		 */
		if ($user->hasAccess('form.create') and $action == 'create')
		{
			// Create the form section
			$newSection = $form->sections()->getModel()->newInstance(Input::all());
			$item = $form->sections()->save($newSection);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('form section'))
				: lang('Short.alert.failure.create', langConcat('form section'));
		}

		/**
		 * Edit a form section.
		 */
		if ($user->hasAccess('form.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Update the section
			$section = $form->sections()->find($id);
			$item = $section->update(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', langConcat('form section'))
				: lang('Short.alert.failure.update', langConcat('form section'));
		}

		/**
		 * Delete the form section.
		 */
		if ($user->hasAccess('form.delete') and $action == 'delete')
		{
			// Get the ID we're deleting
			$id = e(Input::get('id'));

			// Get the new section ID
			$newSectionId = e(Input::get('new_section_id'));

			// Get the section we're deleting
			$section = $form->sections()->find($id);

			if ($section->fields->count() > 0)
			{
				// Loop through the fields and update them
				foreach ($section->fields as $field)
				{
					// Update the section ID
					$field->section_id = $newSectionId;
					$field->save();
				}
			}

			// Delete the section
			$item = $section->delete();

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.delete', langConcat('form section'))
				: lang('Short.alert.failure.delete', langConcat('form section'));
		}

		return Redirect::to("admin/form/sections/{$formKey}")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getFields($formKey, $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.update', 'form.delete'], true);

		// Set the view files
		$this->_view = 'admin/form/fields';
		$this->_jsView = 'admin/form/fields_js';

		// Pass along the form key to the view
		$this->_data->formKey = $formKey;

		// Get the form and pass it along
		$form = $this->_data->form = NovaForm::key($formKey)->first();

		// If there isn't an ID, show all the fields
		if ($id === false)
		{
			// Setup the dynamic form and assemble the elements
			$formOutput = DynamicForm::setup($formKey, false, true);
			$formOutput->assemble();

			// Set up the variables
			$this->_data->tabs = $formOutput->getData('tabs');
			$this->_data->sections = $formOutput->getData('sections');
			$this->_data->fields = $formOutput->getData('fields');

			// Build the delete field modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteField')
				->with('modalHeader', lang('Short.delete', langConcat('Form Field')))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
		else
		{
			// Set the view
			$this->_view = 'admin/form/fields_action';

			// Get the field
			$field = $this->_data->field = $form->fields()->find($id);

			// Set the field types
			$this->_data->types = [
				'text'		=> lang('Text_field'),
				'textarea'	=> lang('Text_area'),
				'select'	=> lang('Dropdown'),
			];

			// Set the access restrictions
			$this->_data->accessRoles = \AccessRole::get();

			// Get the tabs and sections
			$this->_data->tabs[0] = lang('short.selectOne', lang('tab'));
			$this->_data->tabs+= $form->tabs->toSimpleArray('id', 'name');
			$this->_data->sections[0] = lang('short.selectOne', lang('section'));
			$this->_data->sections+= $form->sections->toSimpleArray('id', 'name');

			// Clear out the message for this page
			$this->_data->message = false;

			// ID 0 means a new section, anything else edits an existing section
			if ((int) $id === 0)
			{
				// Set the action
				$this->_mode = $this->_data->action = 'create';
			}
			else
			{
				// Set the action
				$this->_mode = $this->_data->action = 'update';

				// Get the field values
				$this->_data->values = $field->values->sortBy(function($v)
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
					Redirect::to("admin/form/fields/{$field->form->key}/{$id}");
				}
			}
		}
	}
	public function postFields($formKey)
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		// Set up the validation service
		$validator = new FormFieldValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($action == 'delete')
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
		$form = NovaForm::key($formKey)->first();

		/**
		 * Create a form field.
		 */
		if ($user->hasAccess('form.create') and $action == 'create')
		{
			// Create the form field
			$newField = $form->fields()->getModel()->newInstance(Input::all());
			$item = $form->fields()->save($newField);

			if (Input::has('field_values'))
			{
				// Break the values into an array
				$valuesArr = explode(',', Input::get('field_values'));

				foreach ($valuesArr as $key => $value)
				{
					// Create a new form value for this field
					$newValue = $item->values()->getModel()->newInstance([
						'value' => e(trim($value)),
						'order' => $key
					]);
					$item->values()->save($newValue);
				}
			}

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('form field'))
				: lang('Short.alert.failure.create', langConcat('form field'));
		}

		/**
		 * Edit a form field.
		 */
		if ($user->hasAccess('form.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Update the field
			$field = $form->fields()->find($id);
			$item = $field->update(Input::all());

			// Set the flash info
			$flashStatus = (isset($item)) ? 'success' : 'danger';
			$flashMessage = (isset($item)) 
				? lang('Short.alert.success.update', langConcat('form field'))
				: lang('Short.alert.failure.update', langConcat('form field'));
		}

		/**
		 * Delete a form field.
		 */
		if ($user->hasAccess('form.delete') and $action == 'delete')
		{
			// Get the ID we're deleting
			$id = e(Input::get('id'));

			// Delete the field
			$field = $form->fields()->find($id);
			$item = $field->delete();

			// Set the flash info
			$flashStatus = (isset($item)) ? 'success' : 'danger';
			$flashMessage = (isset($item)) 
				? lang('Short.alert.success.delete', langConcat('form field'))
				: lang('Short.alert.failure.delete', langConcat('form field'));
		}

		return Redirect::to("admin/form/fields/{$formKey}")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}