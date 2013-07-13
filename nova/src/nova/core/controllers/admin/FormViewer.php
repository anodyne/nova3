<?php namespace Nova\Core\Controllers\Admin;

use App;
use Sentry;
use NovaForm;
use Redirect;
use DynamicForm;
use NovaFormData;
use AdminBaseController;

class FormViewer extends AdminBaseController {

	public function getView($formKey = false, $formMode = 'view', $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.read', 'form.create', 'form.edit', 'form.delete'], true);

		// Set the JS view
		//$this->_jsView = 'admin/formviewer/view_js';

		if ($formKey === false)
		{
			App::abort(404, lang('error.pageNotFound'));
		}
		else
		{
			// Get the form
			$this->_data->form = $form = NovaForm::key($formKey)->first();

			if ($formMode == 'view')
			{
				// Set the view file
				$this->_view = 'admin/formviewer/entries';

				// Get the entries
				$this->_data->entries = NovaFormData::key($formKey)
					->group('data_id')
					->orderDesc('created_at')
					->get();
			}
			else
			{
				// Set the view file
				$this->_view = 'admin/formviewer/entries_action';

				// Get the entry data
				//$this->_data->entry = NovaFormData::key($formKey)->entry($id)->get();

				// Set the ID
				$this->_data->id = $id;

				// Set the action
				$action = $this->_data->action = ($formMode == 'add') ? 'create' : 'update';

				// Build the form
				$this->_data->form = ($action == 'create')
					? DynamicForm::setup($formKey, 0, true)->build()
					: DynamicForm::setup($formKey, $id, true)->build();
			}
		}
	}
	public function postView($formKey = false)
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
		 * Create the form entry.
		 */
		if ($user->hasAccess('form.read') and $action == 'create')
		{
			// Create the form
			$form = NovaFormData::create(Input::all());

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
				$form = NovaForm::where('id', $id)->update(Input::all());
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
		}

		return Redirect::to("admin/formviewer/{$formKey}")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}