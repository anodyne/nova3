<?php namespace Nova\Core\Controller\Ajax;

/**
 * Controller that handles all ajax requests that deal with getting info.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use Rank;
use View;
use Input;
use Sentry;
use Request;
use Utility;
use Location;
use Position;
use RankCatalog;
use AjaxBaseController;

class Info extends AjaxBaseController {

	/**
	 * Get a position's description.
	 */
	public function getPosition_desc()
	{
		// Set the variable
		$position = e(Input::get('position'));
		$position = (is_numeric($position)) ? $position : false;

		// Get the position
		$item = Position::find($position);

		// Set the output
		$output = (count($item) > 0) ? $item->desc : '';
		
		echo nl2br($output);
	}

	/**
	 * Get the rank image.
	 */
	public function getRank_image()
	{
		// Set the variables
		$rank = e(Input::get('rank'));
		$location = e(Input::get('location'));
		
		// Do a little sanity checking
		$rank = (is_numeric($rank)) ? $rank : false;
		
		// Get the rank
		$rank = Rank::find($rank);
		
		// Set the output
		$output = (count($rank) > 0) 
			? Location::rank($rank->base, $rank->pip, RankCatalog::getDefault(true)) 
			: '';
		
		echo $output;
	}

	/**
	 * Get the preview for a specific rank set.
	 */
	public function getRank_preview($location = false)
	{
		// Clean the variable
		$location = e($location);
		
		// Get the catalog item
		$rank = \Model_Catalog_Rank::getItem($location, 'location');
		
		// Set the output
		$output = (count($rank) > 0) 
			? \HTML::img(\Uri::base(false).'app/assets/common/'.$rank->genre.'/ranks/'.$location.'/'.$rank->preview) 
			: '';
		
		echo $output;
	}

	/**
	 * Get a role's description.
	 */
	public function getRole_desc()
	{
		// Set the variable
		$role = \Security::xss_clean(\Input::post('role', false));
		$role = (is_numeric($role)) ? $role : false;

		// Get the role
		$item = \Model_Access_Role::find($role);

		// Set the output
		$output = (count($item) > 0) ? $item->desc : '';
		
		echo nl2br($output);
	}

	public function getRole_inherited_tasks()
	{
		// Set the variable
		$role = e(Input::get('role'));
		$role = (is_numeric($role)) ? $role : false;

		// Get the role
		$item = \AccessRole::find($role);

		// Start a holding array
		$retval = array();

		// Loop through and get the task IDs
		foreach ($item->tasks as $task)
		{
			$retval[] = $task->id;
		}

		return json_encode($retval);
	}

	/**
	 * Get the roles who have the given task.
	 */
	public function getRoles_with_task()
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('role.read'))
		{
			// Clean the variable
			$id = e(Request::segment(4, false));

			// Get the task
			$task = \AccessTask::find($id);

			echo View::make(Location::file('info/task_roles', Utility::getSkin('admin'), 'ajax'))
				->with('roles', $task->roles);
		}
	}

	/**
	 * Get the preview for a specific skin.
	 */
	public function getSkin_preview($section = false, $location = false)
	{
		// Clean the variables
		$section = \Security::xss_clean($section);
		$location = \Security::xss_clean($location);
		
		// Pull the skin catalog record
		$skin = \Model_Catalog_SkinSec::getItems(array('skin' => $location, 'section' => $section), true);

		// Set the output
		$output = (count($skin) > 0) 
			? \HTML::img(\Uri::base(false).'app/views/'.$location.'/'.$skin->preview) 
			: '';
		
		echo $output;
	}

	/**
	 * Get the users who are assigned a given role.
	 */
	public function getUsers_with_role()
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('role.read'))
		{
			// Clean the variable
			$id = e(Request::segment(4, false));
			
			// Get the role
			$role = \AccessRole::find($id);

			echo View::make(Location::file('info/role_users', Utility::getSkin('admin'), 'ajax'))
				->with('users', $role->users);
		}
	}

}