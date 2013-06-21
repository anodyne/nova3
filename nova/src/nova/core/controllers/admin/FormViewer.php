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

class FormViewer extends AdminBaseController {

	public function __construct()
	{
		parent::__construct();
		
		static::$controllerName = 'form';
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