<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use NovaForm;
use Redirect;
use FormValidator;
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
			->with('modalHeader', lang('Short.edit', lang('form')))
			->with('modalBody', '')
			->with('modalFooter', false);

		// Build the create form modal
		$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
			->with('modalId', 'createForm')
			->with('modalHeader', lang('Short.create', lang('form')))
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

			/**
			 * Tabs
			 */
			if ($form->tabs->count() > 0)
			{
				foreach ($form->tabs as $tab)
				{
					$this->_data->tabs[] = $tab;
				}
			}

			// Manually set the header, footer, and message
			$title = lang('Short.manage', langConcat('Form Tabs'));
			$this->_data->header = $this->_data->title = $title;
			$this->_data->message = lang('sitecontent.message.tabsAll');
		}
		else
		{
			$this->_view = 'admin/form/tabs_action';

			// Get the tabs
			$this->_data->tabs = \Model_Form_Tab::getItems($key);

			// ID 0 means a new tab, anything else edits an existing tab
			if ($id == 0)
			{
				// get the tab
				$this->_data->tab = false;

				// set the action
				$this->_data->action = 'add';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.create', langConcat('form tab')));
				$this->_headers['tabs'] = $this->_titles['tabs'] = $title;
				$this->_messages['tabs'] = false;
			}
			else
			{
				/*
				// get the tab
				$this->_data->tab = \Model_Form_Tab::find($id);

				// if we don't have a tab, redirect to the creation screen
				if ($this->_data->tab === null)
				{
					\Response::redirect('admin/form/tabs/'.$key.'/0');
				}

				// if the tab isn't part of this form, redirect them
				if ($this->_data->tab->form_key != $key)
				{
					\Response::redirect('admin/form/tabs/'.$this->_data->tab->form_key.'/'.$id);
				}

				// set the action
				$this->_data->action = 'update';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.update', langConcat('form tab')));
				$this->_headers['tabs'] = $this->_titles['tabs'] = $title;
				$this->_messages['tabs'] = false;
				*/
			}
		}
	}
	public function postTabs($form, $id = false)
	{
		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$tab_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->hasAccess('form.delete') and $action == 'delete')
				{
					// get the new tab ID
					$new_tab = \Security::xss_clean(\Input::post('new_tab_id'));

					// get the tab we're deleting
					$tab = \Model_Form_Tab::find($tab_id);

					// loop through the sections and update them
					foreach ($tab->sections as $sec)
					{
						// update the tab ID
						$sec->tab_id = $new_tab;

						// save the record
						$sec->save();
					}

					// delete the tab
					$item = \Model_Form_Tab::deleteItem($tab_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.delete', lang('tab'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', lang('tab'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'add')
				{
					// add the tab
					$item = \Model_Form_Tab::createItem(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.create', lang('tab'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.create', lang('tab'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'update')
				{
					// update the tab
					$item = \Model_Form_Tab::updateItem($tab_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.update', lang('tab'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.update', lang('tab'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}
	}

}