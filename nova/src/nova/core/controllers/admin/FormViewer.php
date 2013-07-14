<?php namespace Nova\Core\Controllers\Admin;

use App;
use Input;
use Sentry;
use NovaForm;
use Redirect;
use Validator;
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

		// Get the form
		$this->_data->form = $form = NovaForm::key($formKey)->first();
		$this->_data->formKey = $formKey;
		$this->_data->formMode = $formMode;

		if ($formKey === false)
		{
			App::abort(404, lang('error.pageNotFound'));
		}
		else
		{
			if ($formMode == 'view')
			{
				// Set the view file
				$this->_view = 'admin/formviewer/entries';

				// We use this to figure out what to display
				$this->_data->hasDisplayField = false;

				// Get the entries
				$entries = NovaFormData::key($formKey)
					->group('data_id')
					->orderDesc('created_at');

				if ((int) $form->form_viewer_display > 0)
				{
					// We're going to use what the user specified
					$this->_data->hasDisplayField = true;

					$entries = $entries->where('field_id', $form->form_viewer_display);
				}

				$this->_data->entries = $entries->get();
			}
			else
			{
				// Set the view file
				$this->_view = 'admin/formviewer/entries_action';

				// Set the ID
				$this->_data->id = $id;

				// Set the action
				$action = $this->_data->action = ($formMode == 'add') ? 'create' : 'update';

				// Setup the form
				switch ($formMode)
				{
					case 'add':
						$dynamicForm = DynamicForm::setup($formKey, 0, true);
					break;

					case 'edit':
						$dynamicForm = DynamicForm::setup($formKey, $id, true);
					break;

					case 'detail':
						$dynamicForm = DynamicForm::setup($formKey, $id, false);
					break;
				}

				// Build the form and send it to the view
				$this->_data->dynamicForm = $dynamicForm->build();

				// Get a single entry
				$this->_data->entry = NovaFormData::key($formKey)->entry($id)->first();
			}
		}

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;
		$this->_data->message = ($formMode == 'add') ? $form->form_viewer_message : false;
	}
	public function postView($formKey = false)
	{
		// Get the form
		$form = NovaForm::key($formKey)->first();

		// Set up the validator
		$validator = Validator::make(Input::all(), $form->getFieldValidationRules());

		// If the validation fails, stop and go back
		if ($validator->fails())
		{
			return Redirect::back()->withInput()->withErrors($validator->messages());
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
			// Get the values from the POST
			$input = Input::all();
			$dataId = Input::get('id');

			// If we're creating a new entry, we need to figure out what the ID should be
			if ((int) $dataId === 0)
			{
				// Get all entries and order them by data ID
				$entries = NovaFormData::key($formKey)->orderAsc('data_id')->get();

				if ($entries->count() > 0)
				{
					// Grab the last entry in the collection
					$lastEntry = $entries->last();

					// Increment the data ID
					$dataId = (int) $lastEntry->data_id + 1;
				}
				else
				{
					$dataId = 1;
				}
			}

			foreach ($input as $field => $value)
			{
				if (is_numeric($field))
				{
					NovaFormData::create([
						'form_id'		=> $form->id,
						'field_id'		=> $field,
						'data_id'		=> $dataId,
						'value'			=> trim(e($value)),
						'created_by'	=> Sentry::getUser()->id,
					]);
				}
			}

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.create', langConcat('form entry'));
		}

		/**
		 * Update the form.
		 */
		if ($user->hasAccess('form.update') and $action == 'update')
		{
			// Get the values from the POST
			$input = Input::all();
			$dataId = Input::get('id');

			foreach ($input as $field => $value)
			{
				if (is_numeric($field))
				{
					$data = NovaFormData::entry($dataId)->field($field)->first();
					$data->update(['value' => trim(e($value))]);
				}
			}

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.update', lang('form'));
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