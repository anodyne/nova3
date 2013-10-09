<?php namespace Nova\Core\Controllers\Admin;

use View;
use Event;
use Input;
use Location;
use Redirect;
use Validator;
use DynamicForm;
use AdminBaseController;
use FormRepositoryInterface;

class FormViewer extends AdminBaseController {

	public function __construct(FormRepositoryInterface $form)
	{
		parent::__construct();

		// Set the injected interfaces
		$this->form = $form;
	}

	public function getIndex($formKey)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['form.read', 'form.create', 'form.edit', 'form.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/formviewer/entries_js';

		// Get the form
		$form = $this->_data->form = $this->form->findByKey($formKey);
		$this->_data->formKey = $formKey;

		// Set the view file
		$this->_view = 'admin/formviewer/entries';

		// We use this to figure out what to display
		$this->_data->hasDisplayField = ((int) $form->form_viewer_display > 0) ? true : false;

		// Get the paginated results
		$this->_data->entries = $this->form->getPaginatedFormViewerEntries($form);

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
		$form = $this->form->findByKey($formKey);

		// Get the action
		$formAction = e(Input::get('formAction'));

		// Set up the validator
		$validator = Validator::make(Input::all(), $form->getFieldValidationRules());

		// If the validation fails, stop and go back
		if ($validator->fails())
		{
			if ($formAction == 'delete')
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

		/**
		 * Create the form entry.
		 */
		if ($this->currentUser->hasAccess('form.read') and $formAction == 'create')
		{
			// Create the entry
			$this->form->createFormViewerEntry(Input::get('id'), Input::all(), $form, $this->currentUser);

			if ((bool) $form->email_allowed === true)
			{
				// Set the data being passed to the email
				$emailData = [
					'to'		=> $form->email_addresses,
					'content'	=> DynamicForm::setup($formKey, e(Input::get('id')), false)->build(),
					'subject'	=> str_replace(':0', $form->name, lang('email.subject.formviewer')),
				];

				// Fire a new event
				Event::fire('nova.formviewer.created', $emailData);
			}

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.create', langConcat('form entry'));
		}

		/**
		 * Update the form.
		 */
		if ($this->currentUser->hasAccess('form.update') and $formAction == 'update')
		{
			// Update the entry
			$this->form->updateFormViewerEntry(Input::get('id'), Input::all(), $form);

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.update', langConcat('form entry'));
		}

		/**
		 * Delete the form.
		 */
		if ($this->currentUser->hasAccess('form.delete') and $formAction == 'delete')
		{
			// Delete the entry
			$this->form->deleteFormViewerEntry(Input::get('id'), $form);

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.delete', langConcat('form entry'));
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
		$form = $this->_data->form = $this->form->findByKey($formKey);
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
		$form = $this->_data->form = $this->form->findByKey($formKey);
		$this->_data->formKey = $formKey;
		$this->_data->id = $id;

		// Set the action
		$this->_data->action = 'update';

		// Build the form and send it to the view
		$this->_data->dynamicForm = DynamicForm::setup($formKey, $id, true)->build();

		// Get a single entry
		$this->_data->entry = $this->form->getFormViewerEntry($id);

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;
	}

	public function getDetail($formKey, $id)
	{
		// Set the view file
		$this->_view = 'admin/formviewer/entries_action';

		// Get the form
		$form = $this->_data->form = $this->form->findByKey($formKey);
		$this->_data->formKey = $formKey;

		// Set the action
		$this->_data->action = 'detail';

		// Build the form and send it to the view
		$this->_data->dynamicForm = DynamicForm::setup($formKey, $id, false)->build();

		// Get a single entry
		$this->_data->entry = $this->form->getFormViewerEntry($id, $form);

		// Set the header, title and message
		$this->_data->header = $form->name;
		$this->_data->title.= $form->name;
	}

}