<?php namespace Nova\Core\Controller\Ajax;

use Rank;
use Input;
use Location;
use Position;
use RankCatalog;
use AjaxBaseController;

class Info extends AjaxBaseController {

	/**
	 * Get a position's description.
	 */
	public function actionPosition_desc()
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
	public function actionRank_image()
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
	public function action_rank_preview($location = false)
	{
		// Clean the variable
		$location = \Security::xss_clean($location);
		
		// Get the catalog item
		$rank = \Model_Catalog_Rank::getItem($location, 'location');
		
		// Set the output
		$output = (count($rank) > 0) 
			? \Html::img(\Uri::base(false).'app/assets/common/'.$rank->genre.'/ranks/'.$location.'/'.$rank->preview) 
			: '';
		
		echo $output;
	}

	/**
	 * Get a role's description.
	 */
	public function action_role_desc()
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

	/**
	 * Get the users who are assigned a given role.
	 */
	public function action_role_users($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('role.read'))
		{
			// Clean the variable
			$id = \Security::xss_clean($id);

			// Get the role
			$role = \Model_Access_Role::find($id);

			// Get the users
			$data['users'] = $role->users;

			echo \View::forge(\Location::file('info/role_users', \Utility::getSkin('admin'), 'ajax'), $data);
		}
	}

	/**
	 * Get the preview for a specific skin.
	 */
	public function action_skin_preview($section = false, $location = false)
	{
		// Clean the variables
		$section = \Security::xss_clean($section);
		$location = \Security::xss_clean($location);
		
		// Pull the skin catalog record
		$skin = \Model_Catalog_SkinSec::getItems(array('skin' => $location, 'section' => $section), true);

		// Set the output
		$output = (count($skin) > 0) 
			? \Html::img(\Uri::base(false).'app/views/'.$location.'/'.$skin->preview) 
			: '';
		
		echo $output;
	}

}