<?php namespace Nova\Core\Controllers\Admin;

use App;
use Sentry;
use NovaForm;
use Redirect;
use NovaFormData;
use AdminBaseController;

class FormViewer extends AdminBaseController {

	public function getView($formKey = false, $id = false)
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['form.read', 'form.create', 'form.edit', 'form.delete'], true);

		// Set the JS view
		//$this->_jsView = 'admin/formviewer/view_js';

		// If we don't have a form, throw a 404
		if ($formKey === false)
		{
			App::abort(404, "Page not found");
		}
		else
		{
			// Get the form
			$this->_data->form = $form = NovaForm::key($formKey)->first();

			// If we don't have an ID, show all the records
			if ($id === false)
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
				$this->_data->entry = NovaFormData::key($formKey)->entry($id)->get();

				// Set the action
				$this->_data->action = ((int) $id === 0) ? 'create' : 'update';
			}
		}
	}

}