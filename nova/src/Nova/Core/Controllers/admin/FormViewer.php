<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Notify;
use Sentry;
use Location;
use NovaForm;
use Redirect;
use Validator;
use DynamicForm;
use NovaFormData;
use AdminBaseController;

class FormViewer extends AdminBaseController {

	public function getIndex($formKey)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.read', 'form.create', 'form.edit', 'form.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/formviewer/entries_js';

		// Get the form
		$this->_data->form = $form = NovaForm::key($formKey)->first();
		$this->_data->formKey = $formKey;

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

		$this->_data->entries = $entries->paginate(50);

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;

		// Build the delete form modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'deleteEntry')
			->with('modalHeader', lang('Short.delete', langConcat('Form Entry')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postIndex($formKey)
	{
		// Get the form
		$form = NovaForm::key($formKey)->first();

		// Get the action
		$action = e(Input::get('action'));

		// Set up the validator
		$validator = Validator::make(Input::all(), $form->getFieldValidationRules());

		// If the validation fails, stop and go back
		if ($validator->fails())
		{
			if ($action == 'delete')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to("admin/formviewer/{$formKey}")
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}
			
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

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

			if ((bool) $form->email_allowed === true)
			{
				// Set the content keys
				$contentKeys = [
					'content' => 'email.content.formviewer_results'
				];

				// Set the data being passed to the email
				$emailData = [
					'to'		=> $form->email_addresses,
					'content'	=> DynamicForm::setup($formKey, $dataId, false)->build(),
					'subject'	=> str_replace(':0', $form->name, lang('email.subject.formviewer')),
				];

				// Send the notification
				Notify::send('basic', $emailData, $contentKeys);
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
					$data = NovaFormData::entry($dataId)->formField($field)->first();
					$data->update(['value' => trim(e($value))]);
				}
			}

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.update', langConcat('form entry'));
		}

		/**
		 * Delete the form.
		 */
		if ($user->hasAccess('form.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the entries
			$entries = NovaFormData::key($formKey)->entry($id)->get();

			if ($entries->count() > 0)
			{
				foreach ($entries as $entry)
				{
					$entry->delete();
				}
			}

			// Set the flash info
			$flashStatus = ($entries->count() > 0) ? 'success' : 'danger';
			$flashMessage = ($entries->count() > 0) 
				? lang('Short.alert.success.delete', langConcat('form entry'))
				: lang('Short.alert.failure.delete', langConcat('form entry'));
		}

		return Redirect::to("admin/formviewer/{$formKey}")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getAdd($formKey)
	{
		// Set the view file
		$this->_view = 'admin/formviewer/entries_action';

		// Get the form
		$this->_data->form = $form = NovaForm::key($formKey)->first();
		$this->_data->formKey = $formKey;
		$this->_data->id = 0;

		// Set the action
		$this->_data->action = 'create';

		// Build the form and send it to the view
		$this->_data->dynamicForm = DynamicForm::setup($formKey, 0, true)->build();

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;
		$this->_data->message = $form->form_viewer_message;
	}

	public function getEdit($formKey, $id)
	{
		// Set the view file
		$this->_view = 'admin/formviewer/entries_action';

		// Get the form
		$this->_data->form = $form = NovaForm::key($formKey)->first();
		$this->_data->formKey = $formKey;
		$this->_data->id = $id;

		// Set the action
		$this->_data->action = 'update';

		// Build the form and send it to the view
		$this->_data->dynamicForm = DynamicForm::setup($formKey, $id, true)->build();

		// Get a single entry
		$this->_data->entry = NovaFormData::key($formKey)->entry($id)->first();

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;
	}

	public function getDetail($formKey, $id)
	{
		// Set the view file
		$this->_view = 'admin/formviewer/entries_action';

		// Get the form
		$this->_data->form = $form = NovaForm::key($formKey)->first();
		$this->_data->formKey = $formKey;

		// Set the action
		$this->_data->action = 'detail';

		// Build the form and send it to the view
		$this->_data->dynamicForm = DynamicForm::setup($formKey, $id, false)->build();

		// Get a single entry
		$this->_data->entry = NovaFormData::key($formKey)->entry($id)->first();

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;
	}

}