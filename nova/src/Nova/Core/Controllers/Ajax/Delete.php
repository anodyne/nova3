<?php namespace Nova\Core\Controllers\Ajax;

use Nova;
use View;
use Input;
use Location;
use AjaxBaseController;

class Delete extends AjaxBaseController {

	/**
	 * Show the confirmation modal for deleting a FormViewer entry.
	 *
	 * @param	string	$formKey	Form key
	 * @param	int		$id			Entry ID
	 * @return	View
	 */
	public function getFormViewerEntry($formKey, $id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('form.delete'))
		{
			// Resolve the bindings
			$formModel = Nova::resolveBinding('FormRepositoryInterface');

			// Get the form we're deleting from
			$form = $formModel->findByKey($formKey);

			// Start by not using a display field
			$useDisplayField = false;

			// Start the query to get the entry
			$entry = \FormDataModel::key($formKey)->entry($id);

			// If we have a field to use for display purposes, grab that
			if ((int) $form->form_viewer_display > 0)
			{
				$useDisplayField = true;

				$entry = $entry->where('field_id', $form->form_viewer_display);
			}

			// Get the entry now
			$entry = $entry->first();

			if ($entry)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', langConcat('Form Entry')),
					'modalBody'		=> View::make(Location::ajax('delete/formviewer_entry'))
										->with('name', ($useDisplayField) ? $entry->value : $entry->created_at)
										->with('id', $entry->data_id)
										->with('formKey', $formKey),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a role.
	 *
	 * @param	int		$id		Role ID
	 * @return	View
	 */
	public function getRole($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('role.delete'))
		{
			// Get the role
			$role = \AccessRoleModel::find($id);

			if ($role)
			{
				$data = array(
					'name' 	=> $role->name,
					'id' 	=> $role->id,
				);

				// Get all the roles
				$allRoles = \AccessRoleModel::get();

				// Filter out the role we're deleting
				$data['roles'] = $allRoles->filter(function($r) use ($id)
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
		if ($this->auth->check() and $this->currentUser->hasAccess('role.delete'))
		{
			$task = \AccessTaskModel::find($id);

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
	 * @param	int		$id		Route ID
	 * @return	View
	 */
	public function getRoute($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('routes.delete'))
		{
			$route = \SystemRouteModel::find($id);

			if ($route)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', lang('Route')),
					'modalBody'		=> View::make(Location::ajax('admin/admin/delete_route'))->with('route', $route),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting site content.
	 *
	 * @param	int		$id		Role ID
	 * @return	View
	 */
	public function getSiteContent($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('content.delete'))
		{
			// Resolve the bindings
			$content = Nova::resolveBinding('SiteContentRepositoryInterface');

			// Get the content item
			$item = $content->find($id);

			if ($item)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', langConcat('Site Content')),
					'modalBody'		=> View::make(Location::ajax('delete/sitecontent'))
										->with('sitecontent', $item),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a skin catalog item.
	 *
	 * @param	int		$id		Catalog ID
	 * @return	View
	 */
	public function getSkin($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.delete'))
		{
			$catalog = \SkinCatalogModel::find($id);

			if ($catalog)
			{
				// Get the other active rank sets for this genre
				$catalogs = \SkinCatalogModel::active()->get();

				// Filter out the rank set we're deleting
				$catalogs = $catalogs->filter(function($s) use ($catalog)
				{
					return $s->location != $catalog->location;
				})->toSimpleArray('location', 'name');

				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', lang('Skin')),
					'modalBody'		=> View::make(Location::ajax('delete/skin'))
										->with('skin', $catalog)
										->with('skins', $catalogs),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a user.
	 *
	 * @param	int		$id		User ID
	 * @return	View
	 */
	public function getUser($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('user.delete'))
		{
			$user = \UserModel::find($id);

			if ($user !== null and $user->canBeDeleted())
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', lang('User')),
					'modalBody'		=> View::make(Location::ajax('delete/user'))
										->with('user', $user),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	/**
	 * Show the confirmation modal for deleting a user avatar.
	 *
	 * @param	int		$id		User ID
	 * @return	View
	 */
	public function getUserAvatar($id)
	{
		$user = \UserModel::find($id);

		if ($this->auth->check() and $this->currentUser->canEditUser($user))
		{
			return partial('common/modal_content', [
				'modalHeader'	=> lang('Short.delete', langConcat('User Avatar')),
				'modalBody'		=> View::make(Location::ajax('delete/user_avatar'))
									->with('user', $user),
				'modalFooter'	=> false,
			]);
		}
	}

	/*
	public function action_apprule($id)
	{
		if ($this->auth->check() and $this->currentUser->hasLevel('character.create', 2))
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
		if ($this->auth->check() and $this->currentUser->hasAccess('ban.delete'))
		{
			// get the user
			$user = \UserModel::find(\Security::xss_clean($id));

			// delete the ban
			\BanModel::deleteItem(array('email' => $user->email));

			\SystemEvent::add('user', '[[event.admin.arc.unban_user|{{'.$user->email.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|action.ban|action.removed]]', 1).'</p>';
			echo '<div class="form-actions"><button class="btn close-dialog">'.lang('action.close', 1).'</button></div>';
		}
	}

	public function action_rank($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.delete'))
		{
			// get the rank info
			$rank = \RankModel::find($id);

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
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.delete'))
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
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.delete'))
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
	
	public function getRankSet($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.delete'))
		{
			// Get the catalog we're deleting
			$catalog = \RankCatalogModel::find($id);

			if ($catalog)
			{
				// Get the other active rank sets for this genre
				$catalogs = \RankCatalogModel::active()->currentGenre()->get();

				// Filter out the rank set we're deleting
				$catalogs = $catalogs->filter(function($c) use ($catalog)
				{
					return $c->location != $catalog->location;
				})->toSimpleArray('location', 'name');

				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.delete', ucwords(lang('rank_set'))),
					'modalBody'		=> View::make(Location::ajax('delete/rankset'))
										->with('rank', $catalog)
										->with('ranks', $catalogs),
					'modalFooter'	=> false,
				]);
			}
		}
	}
	*/

}