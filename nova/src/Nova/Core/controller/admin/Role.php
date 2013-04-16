<?php namespace Nova\Core\Controller\Admin;

use Input;
use Sentry;
use Session;
use Redirect;
use AccessRole;
use AccessTask;
use AccessTaskValidator;
use AdminBaseController;

class Role extends AdminBaseController {

	public function getIndex()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed('role.update', true);

		// Set the JS view
		$this->_js_view = 'admin/role/roles_js';

		// Get the role ID from the URI
		$roleID = $this->request->segment(4);

		if ($roleID)
		{
			if ($roleID === 0)
			{
				// Create a new role
			}
			else
			{
				// Edit the selected role
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/role/roles';

			// Get all the roles
			$this->_data->roles = AccessRole::get();

			// Manually set the header and title
			$title = ucwords(lang('short.manage', langConcat('access roles')));
			$this->_data->header = $this->_date->title = $title;
		}
	}
	public function postIndex()
	{
		if (\Input::method() == 'POST')
		{
			$action = \Security::xss_clean(\Input::post('action'));

			if (\Security::check_token())
			{
				/**
				 * Delete a role.
				 */
				if ($action == 'delete')
				{
					// Get the id of the role to delete
					$id = \Security::xss_clean(\Input::post('id'));

					// Get the new id to use
					$newRole = \Security::xss_clean(\Input::post('new_role_id'));

					// Get the role
					$role = \Model_Access_Role::find($id);

					// Loop through all the users and update their roles
					foreach ($role->users as $user)
					{
						$user->role_id = $newRole;
						$user->save();
					}

					// Save the role to lock in the user changes
					$role->save();

					// Now delete the role
					$entry = $role->delete();

					if ($entry)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.success.delete', langConcat('access role'))),
						);

						# TODO: add system event
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.delete', langConcat('access role'))),
						);
					}
				}

				/**
				 * Duplicate a role into a new role.
				 */
				if ($action == 'duplicate')
				{
					// Get the id and name of the role to duplicate
					$id = \Security::xss_clean(\Input::post('id'));
					$name = \Security::xss_clean(\Input::post('name'));

					// Get the item we're duplicating from
					$original = \Model_Access_Role::find($id);

					// Create a new role
					$entry = \Model_Access_Role::createItem(array(
						'name' 		=> $name,
						'desc' 		=> $original->desc,
						'inherits'	=> $original->inherits,
					), true);

					if (is_object($entry))
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.success.duplicate', langConcat('access role'))),
						);

						# TODO: add system event
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.duplicate', langConcat('access role'))),
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

	/**
	 * @todo	Create a new task
	 * @todo	Edit an existing task
	 * @todo	Delete a task
	 */
	public function getTasks()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed('role.read', true);

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
			$cs = array();

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

			// Manually set the header, title and message
			$title = ucwords(lang('short.manage', langConcat('access task')));
			$this->_data->header = $this->_data->title = $title;
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

			// Manually set the header, title and message
			$title = ucwords(lang('short.manage', langConcat('access tasks')));
			$this->_data->header = $this->_data->title = $title;
			$this->_data->message = lang('sitecontent.message.roleTasks');

			// Get the flash status
			$flashStatus = Session::get('flashStatus', null);

			s(Session::has('flashStatus'));

			if ($flashStatus !== null)
			{
				$this->_flash[] = array(
					'status' => Session::get('flashStatus'),
					'message' => Session::get('flashMessage'),
				);

				Session::forget('flashStatus');
				Session::forget('flashMessage');
			}
		}
	}
	public function postTasks()
	{
		// Set the view
		$this->_view = 'processing';

		// Get the action
		$action = e(Input::get('action'));

		// Set up the validation service
		$validator = new AccessTaskValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the current user
		$user = Sentry::getUser();

		/**
		 * Create new task.
		 */
		if ($user->hasAccess('role.create') and $action == 'create')
		{
			// Create the item
			$item = AccessTask::add(Input::all(), true);

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
				// Create the item
				$item = AccessTask::edit($id, Input::all(), true);
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? ucfirst(lang('short.alert.success.update', langConcat('access task')))
				: ucfirst(lang('short.alert.failure.update', langConcat('access task')));

			Session::put('flashStatus', $flashStatus);
			Session::put('flashMessage', $flashMessage);
		}

		return Redirect::to('admin/role/tasks');
	}
	public function deleteTask()
	{
		// Set the view
		$this->_view = 'processing';

		// Only let the user delete if they have the right permissions
		if (Sentry::getUser()->hasAccess('role.delete'))
		{
			// Get the task ID
			$id = is_numeric(e(Input::get('id'))) ?: false;

			// We have a task ID, so continue...
			if ($id)
			{
				// Get the task
				$task = AccessTask::find($id);

				// Delete the records from the pivot table
				$task->roles()->detach();

				// Now delete the task
				$task->delete();

				// Flash the data to the session
				Session::flash('flashStatus', 'success');
				Session::flash('flashMessage', ucfirst(lang('short.alert.success.delete', langConcat('access task'))));
			}
			else
			{
				// Flash the data to the session
				Session::flash('flashStatus', 'danger');
				Session::flash('flashMessage', ucfirst(lang('short.alert.failure.delete', langConcat('access task'))));
			}
		}

		return Redirect::to('admin/role/tasks');
	}

}