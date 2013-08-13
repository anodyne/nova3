<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use Redirect;
use DynamicForm;
use AdminBaseController;
use NovaForm;
use NovaFormTab;
use NovaFormData;
use NovaFormField;
use NovaFormValue;
use NovaFormSection;
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
				$this->_data->form = NovaForm::key($formKey)->first();

				// Get the form fields
				$this->_data->formFields[0] = lang('short.selectOne', langConcat('form field'));
				$this->_data->formFields+= NovaFormField::key($formKey)->active()
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
			$this->_data->forms = NovaForm::get();

			// Build the delete form modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteForm')
				->with('modalHeader', lang('Short.delete', lang('Form')))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postIndex($formKey = false)
	{
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

		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

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

			if ($id and ! $form->protected)
			{
				// Remove all the field data, field values and fields
				if ($form->fields->count() > 0)
				{
					foreach ($form->fields as $field)
					{
						// Remove any data
						if ($field->data->count() > 0)
						{
							foreach ($field->data as $data)
							{
								$data->delete();
							}
						}

						// Remove any field values
						if ($field->values->count() > 0)
						{
							// Remove any values for the field
							foreach ($field->values as $value)
							{
								$value->delete();
							}
						}

						// Remove the field
						$field->delete();
					}
				}

				// Remove the field sections
				if ($form->sections->count() > 0)
				{
					foreach ($form->sections as $section)
					{
						$section->delete();
					}
				}

				// Remove the field tabs
				if ($form->tabs->count() > 0)
				{
					foreach ($form->tabs as $tab)
					{
						$tab->delete();
					}
				}

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

		// Get the tabs
		$tabs = NovaFormTab::key($formKey)->get();

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
			$this->_data->tab = NovaFormTab::find($id);

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
				if ($this->_data->tab->form->form_key != $formKey)
				{
					Redirect::to("admin/form/tabs/{$this->_data->tab->form->form_key}/{$id}");
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
			$item = $form->tabs()->save(new NovaFormTab(Input::all()));

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

			// Get the tab
			$tab = NovaFormTab::find($id);

			// Update the form tab
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
			$tab = NovaFormTab::find($id);

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

		// If there isn't an ID, show all the sections
		if ($id === false)
		{
			// Get the form
			$form = NovaForm::key($formKey)->first();

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
			$this->_data->tabs = NovaFormTab::key($formKey)->get()->toSimpleArray('id', 'name');

			// Get the section
			$this->_data->section = NovaFormSection::find($id);

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
					Redirect::to("admin/form/sections/{$this->_data->section->form->key}/{$id}");
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
			$item = $form->sections()->save(new NovaFormSection(Input::all()));

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

			// Get the section
			$section = NovaFormSection::find($id);

			// Update the form section
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
			$section = NovaFormSection::find($id);

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

		// If there isn't an ID, show all the fields
		if ($id === false)
		{
			// Setup the dynamic form and assemble the elements
			$form = DynamicForm::setup($formKey, false, true);
			$form->assemble();

			// Set up the variables
			$this->_data->tabs = $form->getData('tabs');
			$this->_data->sections = $form->getData('sections');
			$this->_data->fields = $form->getData('fields');

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
			$field = NovaFormField::find($id);

			// Set the field types
			$this->_data->types = [
				'text'		=> lang('Text_field'),
				'textarea'	=> lang('Text_area'),
				'select'	=> lang('Dropdown'),
			];

			// Set the access restrictions
			$this->_data->accessRoles = \AccessRole::get();

			// Send the field to the view
			$this->_data->field = $field;

			// Get the tabs and sections
			$this->_data->tabs[0] = lang('short.selectOne', lang('tab'));
			$this->_data->tabs+= NovaFormTab::key($formKey)->get()->toSimpleArray('id', 'name');
			$this->_data->sections[0] = lang('short.selectOne', lang('section'));
			$this->_data->sections+= NovaFormSection::key($formKey)->get()->toSimpleArray('id', 'name');

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
			$item = $form->fields()->save(new NovaFormField(Input::all()));

			if (Input::has('field_values'))
			{
				// Break the values into an array
				$valuesArr = explode(',', Input::get('field_values'));

				foreach ($valuesArr as $key => $value)
				{
					// Create a new form value for this field
					$item->values()->save(new NovaFormValue(['value' => e(trim($value)), 'order' => $key]));
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

			// Get the field
			$field = NovaFormField::find($id);

			if ($field)
			{
				// Update the form field
				$item = $field->update(Input::all());
			}

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

			// Get the field we're deleting
			$field = NovaFormField::find($id);

			if ($field)
			{
				// Delete the field
				$item = $field->delete();
			}

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