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

}