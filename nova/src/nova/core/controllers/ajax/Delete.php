<?php namespace Nova\Core\Controllers\Ajax;

use View;
use Input;
use Sentry;
use Utility;
use Location;
use AjaxBaseController;

class Delete extends AjaxBaseController {

	public function action_apprule($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasLevel('character.create', 2))
		{
			// get the rule
			$rule = \Model_Application_Rule::find($id);

			if ($rule !== null)
			{
				$data = array(
					'type' => ($rule->type == 'dept') ? lang('department') : lang('global'),
					'id' => $rule->id,
				);

				echo \View::forge(\Location::file('delete/apprule', \Utility::getSkin(), 'ajax'), $data);
			}
		}
	}

	/**
	 * Un-ban a user.
	 *
	 * @return	void
	 */
	public function action_arc_unbanuser($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('ban.delete'))
		{
			// get the user
			$user = \Model_User::find(\Security::xss_clean($id));

			// delete the ban
			\Model_Ban::deleteItem(array('email' => $user->email));

			\SystemEvent::add('user', '[[event.admin.arc.unban_user|{{'.$user->email.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|action.ban|action.removed]]', 1).'</p>';
			echo '<div class="form-actions"><button class="btn close-dialog">'.lang('action.close', 1).'</button></div>';
		}
	}

	/**
	 * Delete a form.
	 *
	 * @return	void
	 */
	public function getForm($formKey)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the form
			$form = \NovaForm::key($formKey)->first();

			// Only present the modal if we're allowed to delete it
			if ((bool) $form->protected === false)
			{
				echo View::make(Location::file('delete/form', Utility::getSkin(), 'ajax'))
					->with('form', $form);
			}
		}
	}

	/**
	 * Show the delete form field modal.
	 *
	 * @param	int		ID to delete
	 * @return	string
	 */
	public function getFormField($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the field we're deleting
			$field = \NovaFormField::find($id);

			if ($field !== null)
			{
				echo View::make(Location::file('delete/field', Utility::getSkin(), 'ajax'))
					->with('name', $field->label)
					->with('id', $field->id)
					->with('formKey', $field->form->key);
			}
		}
	}

	/**
	 * Delete a form field value.
	 *
	 * @return	void
	 */
	public function postFormValue()
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the value
			$id = e(Input::get('id'));

			// Delete the value
			\NovaFormValue::destroy($id);
		}
	}

	/**
	 * Show the delete form section modal.
	 *
	 * @param	int		ID to delete
	 * @return	string
	 */
	public function getFormSection($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the section we're deleting
			$section = \NovaFormSection::find($id);

			if ($section !== null)
			{
				// Get all the sections
				$sections = $section->form->sections->toSimpleArray('id', 'name');

				// Remove the section we are deleting
				unset($sections[$id]);

				echo View::make(Location::file('delete/section', Utility::getSkin(), 'ajax'))
					->with('name', $section->name)
					->with('id', $section->id)
					->with('fields', $section->fields->count())
					->with('sections', $sections)
					->with('formKey', $section->form->key);
			}
		}
	}

	public function getFormTab($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the tab we're deleting
			$tab = \NovaFormTab::find($id);

			if ($tab !== null)
			{
				// Get all the tabs
				$tabs = $tab->form->tabs->toSimpleArray('id', 'name');

				// Remove the tab we are deleting
				unset($tabs[$id]);

				echo View::make(Location::file('delete/tab', Utility::getSkin(), 'ajax'))
					->with('name', $tab->name)
					->with('id', $tab->id)
					->with('tabs', $tabs)
					->with('formKey', $tab->form->key);
			}
		}
	}

	public function action_rank($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.delete'))
		{
			// get the rank info
			$rank = \Model_Rank::find($id);

			if ($rank !== null)
			{
				$data = array(
					'name' => $rank->info->name,
					'id' => $rank->id,
				);

				echo \View::forge(\Location::file('delete/rank', \Utility::getSkin(), 'ajax'), $data);
			}
		}
	}

	public function action_rankgroup($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.delete'))
		{
			// get the rank group
			$group = \Model_Rank_Group::find($id);

			if ($group !== null)
			{
				$data = array(
					'name' => $group->name,
					'id' => $group->id,
				);

				// get all the groups
				$groups = \Model_Rank_Group::getItems(true);

				// create an empty array
				$data['groups'] = array();

				if (count($groups) > 0)
				{
					foreach ($groups as $g)
					{
						if ($g->id != $id)
						{
							$data['groups'][$g->id] = $g->name;
						}
					}
				}

				echo \View::forge(\Location::file('delete/rankgroup', \Utility::getSkin(), 'ajax'), $data);
			}
		}
	}

	public function action_rankinfo($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.delete'))
		{
			// get the rank info
			$info = \Model_Rank_Info::find($id);

			if ($info !== null)
			{
				$data = array(
					'name' => $info->name,
					'id' => $info->id,
				);

				// get all the info records
				$infoItems = \Model_Rank_Info::getItems(true);

				// create an empty array
				$data['infos'] = array();

				if (count($infoItems) > 0)
				{
					foreach ($infoItems as $i)
					{
						$group = ucfirst(lang('group')).' '.$i->group;

						if ($i->id != $id)
						{
							$data['infos'][$group][$i->id] = $i->name;
						}
					}
				}

				echo \View::forge(\Location::file('delete/rankinfo', \Utility::getSkin(), 'ajax'), $data);
			}
		}
	}

	/**
	 * Confirm the deletion of an access role.
	 *
	 * @return	string
	 */
	public function getRole()
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('role.delete'))
		{
			// Get the ID
			$id = e($this->request->segment(4));

			// Get the role
			$role = \AccessRole::find($id);

			if ($role)
			{
				$data = array(
					'name' 	=> $role->name,
					'id' 	=> $role->id,
				);

				// Get all the roles
				$allRoles = \AccessRole::get();

				// Filter out the role we're deleting
				$data['roles'] = $allRoles->filter(function($r) use($id)
				{
					return ($r->id != $id);
				});

				echo View::make(Location::file('delete/role', Utility::getSkin(), 'ajax'), $data);
			}
		}
	}

	/**
	 * Confirm the deletion of an access role task.
	 *
	 * @return	string
	 */
	public function getRole_task()
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('role.delete'))
		{
			// Get the ID
			$id = e($this->request->segment(4));

			// Get the task
			$task = \AccessTask::find($id);

			if ($task)
			{
				echo View::make(Location::file('delete/role_task', Utility::getSkin(), 'ajax'))
					->with('task', $task);
			}
		}
	}

	public function action_user($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('user.delete'))
		{
			// get the user info
			$user = \Model_User::find($id);

			if ($user !== null)
			{
				$data = array(
					'name' => $user->name,
					'id' => $user->id,
				);

				echo \View::forge(\Location::file('delete/user', \Utility::getSkin(), 'ajax'), $data);
			}
		}
	}

	public function getRoute($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('routes.delete'))
		{
			// Get the page route
			$route = \SystemRoute::find($id);

			if ($route)
			{
				echo View::make(Location::file('delete/route', Utility::getSkin(), 'ajax'))
					->with('route', $route);
			}
		}
	}

}