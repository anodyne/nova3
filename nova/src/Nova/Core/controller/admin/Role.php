<?php namespace Nova\Core\Controller\Admin;

use Form;
use View;
use Input;
use Sentry;
use Location;
use Redirect;
use AccessRole;
use AccessTask;
use AccessRoleValidator;
use AccessTaskValidator;
use AdminBaseController;

class Role extends AdminBaseController {

	/**
	 * Manage access roles.
	 */
	public function getIndex()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['role.create', 'role.edit', 'role.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/role/roles_js';

		// Get the role ID from the URI
		$roleID = $this->request->segment(4, false);

		// Get all the roles
		$this->_data->roles = AccessRole::get();

		if ($roleID !== false)
		{
			// Set the view
			$this->_view = 'admin/role/role';

			// Get the role
			$role = AccessRole::find($roleID);
			$this->_data->role = $role;

			// Get all the tasks
			$tasks = AccessTask::get();

			// Loop through the tasks and group them by component
			foreach ($tasks as $t)
			{
				$this->_data->tasks[$t->component][] = $t;
			}

			// If we're editing, grab all the tasks for this role
			if ($roleID > 0)
			{
				// Get the tasks for the role we're editing
				$this->_data->roleTasks = $role->getTasks(false)->toSimpleArray();

				// Now loop through the inherited tasks and get those
				foreach ($role->getInheritedTasks() as $tasks)
				{
					foreach ($tasks as $task)
					{
						$this->_data->inheritedTasks[$task->id] = [
							'name' => $task->name,
							'role' => $task->roles()->first()->name,
						];
					}
				}

				// Set the action
				$this->_data->action = 'update';
			}
			else
			{
				$this->_data->inheritedTasks = array();
				$this->_data->roleTasks = array();

				// Set the action
				$this->_data->action = 'create';
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/role/roles';

			// Build the users with roles modal
			$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
				->with('modalId', 'usersWithRole')
				->with('modalHeader', ucwords(langConcat('users with role')))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the delete roles modal
			$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
				->with('modalId', 'deleteRole')
				->with('modalHeader', ucwords(lang('short.delete', langConcat('access role'))))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the duplicate role modal
			$this->_ajax[] = View::make(Location::file('common/modal', $this->skin, 'partial'))
				->with('modalId', 'duplicateRole')
				->with('modalHeader', ucwords(lang('short.duplicate', langConcat('access role'))))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postIndex()
	{
		// Set up the validation service
		$validator = new AccessRoleValidator;

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
		 * Create a role.
		 */
		if ($user->hasAccess('role.create') and $action == 'create')
		{
			// Create the item
			$item = AccessRole::add(Input::all(), true);

			// Loop through the inherited tasks and get those
			foreach ($item->getInheritedTasks() as $tasks)
			{
				foreach ($tasks as $task)
				{
					$inheritedTasks[] = $task->id;
				}
			}

			// Get the tasks from the POST
			$tasks = Input::get('tasks');

			// Remove the inherited items from the list
			foreach ($tasks as $task)
			{
				if (in_array($task, $inheritedTasks))
				{
					unset($tasks[$task]);
				}
			}

			// Sync the roles_tasks table
			$item->tasks()->sync($tasks);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.create', langConcat('access role')))
				: ucfirst(lang('short.alert.failure.create', langConcat('access role')));
		}

		/**
		 * Duplicate a role.
		 */
		if ($user->hasAccess('role.create') and $action == 'duplicate')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the role we're duplicating
			$role = AccessRole::find($id);

			// Create the item
			$item = AccessRole::add([
				'name'		=> e(Input::get('name')),
				'desc'		=> $role->desc,
				'inherits'	=> $role->inherits,
			], true);

			// Get the original tasks
			$originalTasks = $role->tasks->toSimpleArray();
			$originalTasks = array_keys($originalTasks);

			// Put the tasks into the new role
			$item->tasks()->sync($originalTasks);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? ucfirst(lang('short.alert.success.create', langConcat('access role')))
				: ucfirst(lang('short.alert.failure.create', langConcat('access role')));
		}

		/**
		 * Update the role.
		 */
		if ($user->hasAccess('role.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Get the role
				$role = AccessRole::find($id);

				// Update the role information
				$role->name = e(Input::get('name'));
				$role->desc = e(Input::get('desc'));
				$role->inherits = implode(',', Input::get('inherits'));
				$role->save();

				// Loop through the inherited tasks and get those
				foreach ($role->getInheritedTasks() as $tasks)
				{
					foreach ($tasks as $task)
					{
						$inheritedTasks[] = $task->id;
					}
				}

				// Get the tasks from the POST
				$tasks = Input::get('tasks');

				// Remove the inherited items from the list
				foreach ($tasks as $task)
				{
					if (in_array($task, $inheritedTasks))
					{
						unset($tasks[$task]);
					}
				}

				// Sync the roles_tasks table
				$role->tasks()->sync($tasks);
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? ucfirst(lang('short.alert.success.update', langConcat('access role')))
				: ucfirst(lang('short.alert.failure.update', langConcat('access role')));
		}

		return Redirect::to('admin/role/index')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}
	public function deleteIndex()
	{
		// Only let the user delete if they have the right permissions
		if (Sentry::getUser()->hasAccess('role.delete'))
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

		return Redirect::to('admin/role/index')
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
		}

		return Redirect::to('admin/role/tasks')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}
	public function deleteTasks()
	{
		// Only let the user delete if they have the right permissions
		if (Sentry::getUser()->hasAccess('role.delete'))
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