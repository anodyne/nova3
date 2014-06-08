<?php namespace Nova\Core\Controllers\Ajax;

use Nova;
use View;
use Input;
use Request;
use Location;
use Markdown;
use AjaxBaseController;

class Update extends AjaxBaseController {

	/**
	 * Runs the migrations for a module.
	 *
	 * @return	void
	 */
	public function action_module($module)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.update'))
		{
			// move up to the latest migration
			\Migrate::latest($module, 'module');

			\SystemEvent::add('user', '[[event.admin.catalog.module_update|{{'.$module.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|module|action.updated]]').'</p>';
			echo '<div class="form-actions"><button class="btn modal-close">'.lang('action.close', 1).'</button></div>';
		}
	}

	/**
	 * Duplicate a rank group.
	 *
	 * @param	int		the ID of the rank group being duplicated
	 * @return	void
	 */
	public function action_rankgroup($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.update'))
		{
			$id = \Security::xss_clean($id);

			// get the rank group
			$group = \Model_Rank_Group::find($id);

			// set the data
			$data['id'] = $id;

			if ($group !== false)
			{
				$data['name'] = $group->name;
				$data['order'] = $group->order;
				$data['status'] = (int) $group->status;
			}

			echo \View::forge(\Location::ajax('update/rankgroup'), $data);
		}
	}

	/**
	 * Updates the rank group order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_rankgroup_order()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.update'))
		{
			// get and sanitize the input
			$sets = \Security::xss_clean(\Input::post('group'));

			foreach ($sets as $key => $value)
			{
				// get the group record
				$record = \Model_Rank_Group::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}

	/**
	 * Update a rank info record.
	 *
	 * @param	int		the ID of the rank info being edited
	 * @return	void
	 */
	public function action_rankinfo($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.update'))
		{
			$id = \Security::xss_clean($id);

			// get the rank group
			$info = \Model_Rank_Info::find($id);

			// set the data
			$data['id'] = $id;
			$data['action'] = 'update';

			if ($info !== false)
			{
				$data['name'] = $info->name;
				$data['short_name'] = $info->short_name;
				$data['order'] = $info->order;
				$data['group'] = $info->group;
				$data['status'] = (int) $info->status;
			}

			echo \View::forge(\Location::ajax('update/rankinfo'), $data);
		}
	}

	/**
	 * Updates the rank info order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_rankinfo_order()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.update'))
		{
			// get and sanitize the input
			$info = \Security::xss_clean(\Input::post('info'));

			foreach ($info as $key => $value)
			{
				// get the group record
				$record = \Model_Rank_Info::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}

	/**
	 * Confirm updating a skin.
	 *
	 * @param	string	The catalog ID
	 * @return	void
	 */
	public function getSkinVersionUpdate($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.update'))
		{
			// Get the catalog
			$catalog = \SkinCatalogModel::find($id);

			if ($catalog)
			{
				return View::make(Location::ajax('update/skin'))
					->with('skin', $catalog);
			}
		}
	}
	
}