<?php namespace Nova\Core\Controllers\Ajax;

use View;
use Input;
use Sentry;
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

				echo \View::forge(\Location::ajax('delete/apprule'), $data);
			}
		}
	}

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
	 * Show the confirmation modal for deleting a form.
	 *
	 * @param	string	Form key
	 * @return	View
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
				echo View::make(Location::ajax('delete/form'))
					->with('form', $form);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a form field.
	 *
	 * @param	int		Form field ID
	 * @return	View
	 */
	public function getFormField($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the field we're deleting
			$field = \NovaFormField::find($id);

			if ($field !== null)
			{
				echo View::make(Location::ajax('delete/field'))
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
	 * Show the confirmation modal for deleting a form section.
	 *
	 * @param	int		Form section ID
	 * @return	View
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

				echo View::make(Location::ajax('delete/section'))
					->with('name', $section->name)
					->with('id', $section->id)
					->with('fields', $section->fields->count())
					->with('sections', $sections)
					->with('formKey', $section->form->key);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a form tab.
	 *
	 * @param	int		Form tab ID
	 * @return	View
	 */
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

				echo View::make(Location::ajax('delete/tab'))
					->with('name', $tab->name)
					->with('id', $tab->id)
					->with('tabs', $tabs)
					->with('formKey', $tab->form->key);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a FormViewer entry.
	 *
	 * @param	string	Form key
	 * @param	int		Entry ID
	 * @return	View
	 */
	public function getFormViewerEntry($formKey, $id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.delete'))
		{
			// Get the form we're deleting from
			$form = \NovaForm::key($formKey)->first();

			$useDisplayField = false;

			// Start the query to get the entry
			$entry = \NovaFormData::key($formKey)->entry($id);

			// If we have a field to use for display purposes, grab that
			if ((int) $form->form_viewer_display > 0)
			{
				$useDisplayField = true;

				$entry = $entry->where('field_id', $form->form_viewer_display);
			}

			// Get the entry now
			$entry = $entry->first();

			if ($entry !== null)
			{
				echo View::make(Location::ajax('delete/formviewer_entry'))
					->with('name', ($useDisplayField) ? $entry->value : $entry->created_at)
					->with('id', $entry->data_id)
					->with('formKey', $formKey);
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

				echo \View::forge(\Location::ajax('delete/rank'), $data);
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

				echo \View::forge(\Location::ajax('delete/rankgroup'), $data);
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

				echo \View::forge(\Location::ajax('delete/rankinfo'), $data);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a rank catalog item.
	 *
	 * @param	int		Catalog ID
	 * @return	View
	 */
	public function getRankSet($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('catalog.delete'))
		{
			// Get the catalog we're deleting
			$catalog = \RankCatalog::find($id);

			if ($catalog !== null)
			{
				// Get the other active rank sets for this genre
				$catalogs = \RankCatalog::active()->currentGenre()->get();

				// Filter out the rank set we're deleting
				$catalogs = $catalogs->filter(function($r) use($catalog)
				{
					return $r->location != $catalog->location;
				})->toSimpleArray('location', 'name');

				echo View::make(Location::ajax('delete/rankset'))
					->with('rank', $catalog)
					->with('ranks', $catalogs);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a role.
	 *
	 * @param	int		Role ID
	 * @return	View
	 */
	public function getRole($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('role.delete'))
		{
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

				echo View::make(Location::ajax('delete/role'), $data);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a role task.
	 *
	 * @param	int		Role task ID
	 * @return	View
	 */
	public function getRoleTask($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('role.delete'))
		{
			$task = \AccessTask::find($id);

			if ($task)
			{
				echo View::make(Location::ajax('delete/role_task'))
					->with('task', $task);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a route.
	 *
	 * @param	int		Route ID
	 * @return	View
	 */
	public function getRoute($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('routes.delete'))
		{
			$route = \SystemRoute::find($id);

			if ($route)
			{
				echo View::make(Location::ajax('delete/route'))
					->with('route', $route);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a skin catalog item.
	 *
	 * @param	int		Catalog ID
	 * @return	View
	 */
	public function getSkin($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('catalog.delete'))
		{
			$catalog = \SkinCatalog::find($id);

			if ($catalog !== null)
			{
				// Get the other active rank sets for this genre
				$catalogs = \SkinCatalog::active()->get();

				// Filter out the rank set we're deleting
				$catalogs = $catalogs->filter(function($r) use($catalog)
				{
					return $r->location != $catalog->location;
				})->toSimpleArray('location', 'name');

				echo View::make(Location::ajax('delete/skin'))
					->with('skin', $catalog)
					->with('skins', $catalogs);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a user.
	 *
	 * @param	int		User ID
	 * @return	View
	 */
	public function getUser($id)
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('user.delete'))
		{
			$user = \User::find($id);

			if ($user !== null and $user->canBeDeleted())
			{
				$data = array(
					'name' => $user->name,
					'id' => $user->id,
				);

				echo View::make(Location::ajax('delete/user'))
					->with('user', $user);
			}
		}
	}

}