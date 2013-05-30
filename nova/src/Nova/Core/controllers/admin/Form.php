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
	}
	public function postIndex()
	{
		// Set up the validation service
		$validator = new FormValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

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

	/**
	 * Manage tasks associated with access roles.
	 */
	public function getTasks()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['role.create', 'role.edit', 'role.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/role/tasks_js';

		// Get the task ID from the URI
		$taskID = $this->request->segment(4, false);

		if ($taskID !== false)
		{
			// Set the view
			$this->_view = 'admin/role/task';

			// Get the task
			$this->_data->task = (is_numeric($taskID)) ? AccessTask::find($taskID) : false;

			// Get all the task components
			$components = AccessTask::getComponents();

			// Storage array
			$cs = [];

			// Loop through the tasks and get the components
			foreach ($components as $c)
			{
				if ( ! in_array($c->component, $cs))
				{
					$cs[] = $c->component;
				}
			}

			// Set the list of components
			$this->_data->componentSource = json_encode($cs);

			// Set the list of actions
			$this->_data->actionSource = json_encode(array('create', 'read', 'update', 'delete'));

			// Set the action
			$this->_data->action = ($taskID == 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->_view = 'admin/role/tasks';

			// Get all the tasks
			$tasks = AccessTask::get();

			// Loop through the tasks and group them by component
			foreach ($tasks as $t)
			{
				$this->_data->tasks[$t->component][] = $t;
			}

			// Build the delete task modal
			$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
				->with('modalId', 'deleteTask')
				->with('modalHeader', ucwords(lang('short.delete', lang('task'))))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the roles with task modal
			$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
				->with('modalId', 'rolesWithTask')
				->with('modalHeader', ucwords(langConcat('access roles with task')))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postTasks()
	{
		// Set up the validation service
		$validator = new AccessTaskValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		/**
		 * Create new task.
		 */
		if ($user->hasAccess('role.create') and $action == 'create')
		{
			// Create the item
			$item = AccessTask::create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.create', langConcat('access task')))
				: ucfirst(lang('short.alert.failure.create', langConcat('access task')));
		}

		/**
		 * Update task.
		 */
		if ($user->hasAccess('role.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Update the task
				$item = AccessTask::where('id', $id)->update(Input::all());
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? ucfirst(lang('short.alert.success.update', langConcat('access task')))
				: ucfirst(lang('short.alert.failure.update', langConcat('access task')));
		}

		/**
		 * Delete task.
		 */
		if ($user->hasAccess('role.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// We have a task ID, so continue...
			if ($id)
			{
				// Get the task
				$task = AccessTask::find($id);

				// Delete the records from the pivot table
				$task->roles()->detach();

				// Now delete the task
				$task->delete();

				// Set the flash info
				$flashStatus = 'success';
				$flashMessage = ucfirst(lang('short.alert.success.delete', langConcat('access task')));
			}
			else
			{
				// Set the flash info
				$flashStatus = 'danger';
				$flashMessage = ucfirst(lang('short.alert.failure.delete', langConcat('access task')));
			}
		}

		return Redirect::to('admin/role/tasks')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}