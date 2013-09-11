<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Location;
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
		$this->role = $role;
	}

	/**
	 * Manage access roles.
	 */
	public function getIndex($roleId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['role.create', 'role.edit', 'role.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/role/roles_js';

		// Get all the roles
		$roles = $this->_data->roles = $this->role->all();

		if ($roleId !== false)
		{
			// Set the view
			$this->_view = 'admin/role/roles_action';

			// Get the role
			$role = $this->_data->role = $this->role->find($roleId);

			// Get all the tasks
			$tasks = $this->role->allTasks();

			// Loop through the tasks and group them by component
			foreach ($tasks as $t)
			{
				$this->_data->tasks[$t->component][] = $t;
			}

			// If we're editing, grab all the tasks for this role
			if ($roleId > 0)
			{
				// Get the tasks for the role we're editing
				$this->_data->roleTasks = $role->getTasks(false)->toSimpleArray();

				// Set the inherited tasks array
				$this->_data->inheritedTasks = [];

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
				$this->_mode = $this->_data->action = 'update';
			}
			else
			{
				$this->_data->inheritedTasks = [];
				$this->_data->roleTasks = [];

				// Set the action
				$this->_mode = $this->_data->action = 'create';
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/role/roles';

			// Build the users with roles modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'usersWithRole')
				->with('modalHeader', langConcat('Users with Role'))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the delete roles modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteRole')
				->with('modalHeader', lang('Short.delete', langConcat('Access Role')))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the duplicate role modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'duplicateRole')
				->with('modalHeader', lang('Short.duplicate', langConcat('Access Role')))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postIndex()
	{
		// Get the input
		$input = Input::all();

		// Get the action
		$formAction = e($input['formAction']);

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
			$return = $this->performRoleCreate($input);
		}

		/**
		 * Duplicate a role.
		 */
		if ($this->currentUser->hasAccess('role.create') and $formAction == 'duplicate')
		{
			$return = $this->performRoleDuplicate($input);
		}

		/**
		 * Update the role.
		 */
		if ($this->currentUser->hasAccess('role.update') and $formAction == 'update')
		{
			$return = $this->performRoleUpdate($input);
		}

		/**
		 * Delete the role.
		 */
		if ($this->currentUser->hasAccess('role.delete') and $formAction == 'delete')
		{
			$return = $this->performRoleDelete($input);
		}

		return Redirect::to('admin/role')
			->with('flashStatus', $return['status'])
			->with('flashMessage', $return['message']);
	}

	/**
	 * Manage tasks associated with access roles.
	 */
	public function getTasks($taskId = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['role.create', 'role.edit', 'role.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/role/tasks_js';

		if ($taskId !== false)
		{
			// Set the view
			$this->_view = 'admin/role/tasks_action';

			// Get the task
			$task = $this->_data->task = (is_numeric($taskId)) ? $this->role->findTask($taskId) : false;

			// Get all the task components
			$components = $this->role->getTaskComponents();

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
			$this->_jsData->componentSource = json_encode($cs);

			// Set the list of actions
			$this->_jsData->actionSource = json_encode(['create', 'read', 'update', 'delete']);

			// Set the action
			$this->_mode = $this->_data->action = ($taskId == 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->_view = 'admin/role/tasks';

			// Get all the tasks
			$tasks = $this->role->allTasks();

			// Loop through the tasks and group them by component
			foreach ($tasks as $t)
			{
				$this->_data->tasks[$t->component][] = $t;
			}

			// Build the delete task modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteTask')
				->with('modalHeader', lang('Short.delete', lang('Task')))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the roles with task modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'rolesWithTask')
				->with('modalHeader', langConcat('Access Roles with Task'))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postTasks()
	{
		// Get the action
		$formAction = e(Input::get('formAction'));

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
			$return = $this->performTaskCreate($input);
		}

		/**
		 * Update task.
		 */
		if ($this->currentUser->hasAccess('role.update') and $formAction == 'update')
		{
			$return = $this->performTaskUpdate($input);
		}

		/**
		 * Delete task.
		 */
		if ($this->currentUser->hasAccess('role.delete') and $formAction == 'delete')
		{
			$return = $this->performTaskDelete($input);
		}

		return Redirect::to('admin/role/tasks')
			->with('flashStatus', $return['status'])
			->with('flashMessage', $return['message']);
	}

	/**
	 * Access role actions.
	 */
	protected function performRoleCreate(array $input)
	{
		// Create the item
		$item = $this->role->create($input);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.create', langConcat('access role'))
				: lang('Short.alert.failure.create', langConcat('access role'))
		];
	}
	protected function performRoleDuplicate(array $input)
	{
		// Duplicate the role
		$item = $this->role->duplicate($input['id'], $input);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.duplicate', langConcat('access role'))
				: lang('Short.alert.failure.duplicate', langConcat('access role'))
		];
	}
	protected function performRoleUpdate(array $input)
	{
		// Update the role
		$item = $this->role->update($input['id'], $input);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.update', langConcat('access role'))
				: lang('Short.alert.failure.update', langConcat('access role'))
		];
	}
	protected function performRoleDelete(array $input)
	{
		// Delete the role
		$item = $this->role->delete($input['id'], $input['new_role_id']);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.delete', langConcat('access role'))
				: lang('Short.alert.failure.delete', langConcat('access role'))
		];
	}

	/**
	 * Access role task actions.
	 */
	protected function performTaskCreate(array $input)
	{
		// Create the item
		$item = $this->role->createTask($input);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.create', langConcat('access task'))
				: lang('Short.alert.failure.create', langConcat('access task'))
		];
	}
	protected function performTaskUpdate(array $input)
	{
		// Update the role
		$item = $this->role->updateTask($input['id'], $input);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.update', langConcat('access task'))
				: lang('Short.alert.failure.update', langConcat('access task'))
		];
	}
	protected function performTaskDelete(array $input)
	{
		// Delete the role
		$item = $this->role->deleteTask($input['id']);

		return [
			'status'	=> ($item) ? 'success' : 'danger',
			'message'	=> ($item) 
				? lang('Short.alert.success.delete', langConcat('access task'))
				: lang('Short.alert.failure.delete', langConcat('access task'))
		];
	}

}