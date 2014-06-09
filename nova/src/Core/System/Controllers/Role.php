<?php namespace Nova\Core\Controllers\Admin;

use Input;
use Redirect;
use AccessRoleValidator;
use AccessTaskValidator;
use AdminBaseController;
use AccessRoleRepositoryInterface;

class Role extends AdminBaseController {

	public function __construct(AccessRoleRepositoryInterface $role)
	{
		parent::__construct();

		// Set the injected interfaces
		$this->roles = $role;
	}

	/**
	 * Manage access roles.
	 */
	public function getIndex($roleId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['role.create', 'role.edit', 'role.delete'], true);

		// Set the JS view
		$this->jsView = 'admin/role/roles_js';

		// Get all the roles
		$this->data->roles = $this->roles->all();

		if ($roleId !== false)
		{
			// Set the view
			$this->view = 'admin/role/roles_action';

			// Get the role
			$role = $this->data->role = $this->roles->find($roleId);

			// Get all the tasks
			$this->data->tasks = $this->roles->allTasks()->toMultiArray('component');

			// If we're editing, grab all the tasks for this role
			if ((int) $roleId > 0)
			{
				// Get the tasks for the role we're editing
				$this->data->roleTasks = $role->getTasks(false)->toSimpleArray();

				// Set the inherited tasks array
				$this->data->inheritedTasks = [];

				// Now loop through the inherited tasks and get those
				foreach ($role->getInheritedTasks() as $tasks)
				{
					foreach ($tasks as $task)
					{
						$this->data->inheritedTasks[$task->id] = [
							'name' => $task->name,
							'role' => $task->roles()->first()->name,
						];
					}
				}

				// Set the action
				$this->mode = $this->data->action = 'update';
			}
			else
			{
				$this->data->inheritedTasks = [];
				$this->data->roleTasks = [];

				// Set the action
				$this->mode = $this->data->action = 'create';
			}
		}
		else
		{
			// Set the view
			$this->view = 'admin/role/roles';

			// Build the users with roles modal
			$this->ajax[] = modal([
				'id'		=> 'usersWithRole',
				'header'	=> langConcat('Users with Role')
			]);

			// Build the delete roles modal
			$this->ajax[] = modal([
				'id'		=> 'deleteRole',
				'header'	=> lang('Short.delete', langConcat('Access Role'))
			]);

			// Build the duplicate role modal
			$this->ajax[] = modal([
				'id'		=> 'duplicateRole',
				'header'	=> lang('Short.duplicate', langConcat('Access Role'))
			]);
		}
	}
	public function postIndex()
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new AccessRoleValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($formAction == 'delete' or $formAction == 'duplicate')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/role')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}

			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		/**
		 * Create a role.
		 */
		if ($this->currentUser->hasAccess('role.create') and $formAction == 'create')
		{
			// Create the item
			$item = $this->role->create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('access role'))
				: lang('Short.alert.failure.create', langConcat('access role'));
		}

		/**
		 * Duplicate a role.
		 */
		if ($this->currentUser->hasAccess('role.create') and $formAction == 'duplicate')
		{
			// Duplicate the role
			$item = $this->role->duplicate(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('access role'))
				: lang('Short.alert.failure.create', langConcat('access role'));
		}

		/**
		 * Update the role.
		 */
		if ($this->currentUser->hasAccess('role.update') and $formAction == 'update')
		{
			// Update the role
			$item = $this->role->update(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', langConcat('access role'))
				: lang('Short.alert.failure.update', langConcat('access role'));
		}

		/**
		 * Delete the role.
		 */
		if ($this->currentUser->hasAccess('role.delete') and $formAction == 'delete')
		{
			// Delete the role
			$item = $this->role->delete(Input::get('id'), Input::get('new_role_id'));

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.delete', langConcat('access role'))
				: lang('Short.alert.failure.delete', langConcat('access role'));
		}

		return Redirect::to('admin/role')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	/**
	 * Manage tasks associated with access roles.
	 */
	public function getTasks($taskId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['role.create', 'role.edit', 'role.delete'], true);

		// Set the JS view
		$this->jsView = 'admin/role/tasks_js';

		if ($taskId !== false)
		{
			// Set the view
			$this->view = 'admin/role/tasks_action';

			// Get the task
			$this->data->task = $this->roles->findTask($taskId);

			// Get all the task components
			$components = $this->roles->getTaskComponents();

			// Set the list of components
			$this->jsData->componentSource = json_encode($components->toSimpleArray(false, 'component'));

			// Set the list of actions
			$this->jsData->actionSource = json_encode(['create', 'read', 'update', 'delete']);

			// Set the action
			$this->mode = $this->data->action = ((int) $taskId == 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->view = 'admin/role/tasks';

			// Get all the tasks
			$this->data->tasks = $this->roles->allTasks()->toMultiArray('component');

			// Build the delete task modal
			$this->ajax[] = modal([
				'id'		=> 'deleteTask',
				'header'	=> lang('Short.delete', lang('Task'))
			]);

			// Build the roles with task modal
			$this->ajax[] = modal([
				'id'		=> 'rolesWithTask',
				'header'	=> langConcat('Access Roles with Task')
			]);
		}
	}
	public function postTasks()
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new AccessTaskValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($formAction == 'delete')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/role/tasks')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}

			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		/**
		 * Create new task.
		 */
		if ($this->currentUser->hasAccess('role.create') and $formAction == 'create')
		{
			// Create the item
			$item = $this->role->createTask(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', langConcat('access task'))
				: lang('Short.alert.failure.create', langConcat('access task'));
		}

		/**
		 * Update task.
		 */
		if ($this->currentUser->hasAccess('role.update') and $formAction == 'update')
		{
			// Update the task
			$item = $this->role->updateTask(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', langConcat('access task'))
				: lang('Short.alert.failure.update', langConcat('access task'));
		}

		/**
		 * Delete task.
		 */
		if ($this->currentUser->hasAccess('role.delete') and $formAction == 'delete')
		{
			// Delete the task
			$item = $this->role->deleteTask(Input::get('id'));

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.delete', langConcat('access task'))
				: lang('Short.alert.failure.delete', langConcat('access task'));
		}

		return Redirect::to('admin/role/tasks')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

}