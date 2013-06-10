<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use NovaForm;
use Redirect;
use NovaFormTab;
use NovaFormData;
use FormValidator;
use FormTabValidator;
use AdminBaseController;

class Form extends AdminBaseController {

	public function __construct()
	{
		parent::__construct();
		
		static::$controllerName = 'form';
	}

	/**
	 * Manage dynamic forms.
	 */
	public function getIndex()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.edit', 'form.delete'], true);

		// Set the view files
		$this->_view = 'admin/form/index';
		$this->_jsView = 'admin/form/index_js';

		// Get all the forms
		$this->_data->forms = NovaForm::get();

		// Build the edit form modal
		$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
			->with('modalId', 'updateForm')
			->with('modalHeader', lang('Short.edit', lang('Form')))
			->with('modalBody', '')
			->with('modalFooter', false);

		// Build the create form modal
		$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
			->with('modalId', 'createForm')
			->with('modalHeader', lang('Short.create', lang('Form')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postIndex()
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
				? ucfirst(lang('short.alert.success.create', lang('form')))
				: ucfirst(lang('short.alert.failure.create', lang('form')));
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
				$form = NovaForm::where('id', $id)->update(Input::all());
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? ucfirst(lang('short.alert.success.update', lang('form')))
				: ucfirst(lang('short.alert.failure.update', lang('form')));
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
				// Remove all the tabs, sections, fields and values

				// Delete the form
				$item = $form->delete();
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? ucfirst(lang('short.alert.success.delete', lang('form')))
				: ucfirst(lang('short.alert.failure.delete', lang('form')));
		}

		return Redirect::to('admin/form')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getTabs($formKey, $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.edit', 'form.delete'], true);

		// Set the view files
		$this->_view = 'admin/form/tabs';
		$this->_jsView = 'admin/form/tabs_js';

		// Pass along the form key to the view
		$this->_data->formKey = $formKey;

		// Get the form
		$form = NovaForm::getForm($formKey);

		// If there isn't an ID, show all the tabs
		if ($id === false)
		{
			// Set up the variables
			$this->_data->tabs = false;

			if ($form->tabs->count() > 0)
			{
				foreach ($form->tabs as $tab)
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
				$this->_data->action = 'create';
			}
			else
			{
				// Set the action
				$this->_data->action = 'update';

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
		$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
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
		$form = NovaForm::getForm($formKey);

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

	public function getView($formKey = false, $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.create', 'form.edit', 'form.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/form/view_js';

		// If we don't have a form, show all the forms
		if ($formKey === false)
		{
			// Set the view file
			$this->_view = 'admin/form/formviewer_all';

			// Get all the forms
			$this->_data->forms = NovaForm::formViewer()->get();
		}

		// If we do have a form, show all the records
		if ($formKey !== false)
		{
			// Get the form
			$this->_data->form = $form = NovaForm::getForm($formKey);

			// If we don't have an ID, show all the records
			if ($id === false)
			{
				// Set the view file
				$this->_view = 'admin/form/formviewer_one';

				// Get the entries
				$this->_data->entries = NovaFormData::form($form->id)
					->group('data_id')
					->orderDesc('created_at')
					->get();
			}

			// If we have an ID, show that record
			if ($id !== false)
			{
				// Set the view file
				$this->_view = 'admin/form/formviewer_detail';

				// Get the entry
				$this->_data->entry = NovaFormData::form($form->id)->entry($id)->get();
			}
		}
	}
	public function deleteView($formKey, $id)
	{
		# code...
	}

}