<?php namespace nova\core\controllers\ajax;

use Nova;
use View;
use Input;
use Sentry;
use Request;
use Location;
use Markdown;
use AjaxBaseController;

class Get extends AjaxBaseController {

	public function action_content_load()
	{
		// get the content key
		$key = \Input::get('key');

		// load and return the content from the database
		echo \Model_SiteContent::getContent($key);
	}

public function action_user()
	{
		// set the field and values
		$field = false;
		$value = false;

		// loop through the data and set the field and value
		foreach (\Input::post() as $k => $v)
		{
			$field = $k;
			$value = $v;
		}

		// Find the user
		$user = \Model_User::query()->where($field, $value)->get_one();

		if ($user)
		{
			echo \Format::forge($user)->to_json();
		}
		else
		{
			echo \Format::forge(array())->to_json();
		}
	}

	public function action_user_form()
	{
		// get the POST data
		$data = \Input::post();

		echo \NovaForm::build(
			'user', 
			\Security::xss_clean(\Input::post('skin')),
			\Security::xss_clean(\Input::post('user'))
		);
	}

	public function action_user_search()
	{
		if (\Sentry::check())
		{
			// sanitize the input
			$query = \Security::xss_clean(\Input::get('query'));

			// empty array for storing the results
			$retval = array();

			if ( ! empty($query))
			{
				$only_search_email = (bool) preg_match('(@)', $query);

				// search for any users with the email address
				$email = \Model_User::getItem("%$query%", 'email', true);

				if (count($email) > 0)
				{
					foreach ($email as $e)
					{
						$retval['email'][] = array(
							'id' => $e->id,
							'name' => $e->name,
							'email' => $e->email,
						);
					}
				}
				
				if ( ! $only_search_email)
				{
					// search for any users with the name
					$name = \Model_User::getItem("%$query%", 'name', true);

					if (count($name) > 0)
					{
						foreach ($name as $n)
						{
							$retval['name'][] = array(
								'id' => $n->id,
								'name' => $n->name,
								'email' => $n->email,
							);
						}
					}

					// search for first names
					$first_name = \Model_Character::getItem("%$query%", 'first_name', true);

					if (count($first_name) > 0)
					{
						foreach ($first_name as $c)
						{
							$retval['characters'][$c->user->id] = array(
								'id' => $c->user->id,
								'name' => $c->user->name,
								'email' => $c->user->email,
								'fname' => $c->first_name,
								'lname' => $c->last_name,
							);
						}
					}

					// search for last names
					$last_name = \Model_Character::getItem("%$query%", 'last_name', true);

					if (count($last_name) > 0)
					{
						foreach ($last_name as $c)
						{
							$retval['characters'][$c->user->id] = array(
								'id' => $c->user->id,
								'name' => $c->user->name,
								'email' => $c->user->email,
								'fname' => $c->first_name,
								'lname' => $c->last_name,
							);
						}
					}
				}
			}
			else
			{
				$retval = array();
			}
			
			echo json_encode($retval);
		}
	}

	/**
	 * Get a position record.
	 */
	public function getPosition($id, $return = false)
	{
		// Sanity check
		$id = ( ! is_numeric($id)) ? false : $id;

		// Get the position
		$position = \Position::with('dept')->where('id', $id)->first();

		// Figure out what to output
		switch ($return)
		{
			case 'json':
				return $position->toJson();
			break;

			case 'deptname':
				return $position->dept->name;
			break;

			case 'deptdesc':
				return $position->dept->desc;
			break;

			default:
				return e($position->{$return});
			break;
		}
	}

	/**
	 * Get a rank record.
	 */
	public function getRank($id, $return = false)
	{
		// Sanity check
		$id = ( ! is_numeric($id)) ? false : $id;

		// Get the rank
		$rank = \Rank::with('info')->where('id', $id)->first();

		// Figure out what to output
		switch ($return)
		{
			case 'image':
				return Location::rank($rank->base, $rank->pip, Nova::getRank());
			break;

			case 'json':
				return $rank->toJson();
			break;

			case 'name':
				return $rank->info->name;
			break;

			case 'shortname':
				return $rank->info->short_name;
			break;

			default:
				return e($rank->{$return});
			break;
		}
	}

	/**
	 * Get a role's description.
	 */
	public function getRoleDesc()
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
	 * Get the preview for a specific skin.
	 */
	public function getSkinPreview($section, $location)
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

	public function postRoleInheritedTasks()
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
	public function postRolesWithTask($id, $format = 'html')
	{
		if (Sentry::check())
		{
			// What type of request is it?
			$format = e($format);

			// Clean the variable
			$id = e($id);

			// Get the task
			$task = \AccessTask::find($id);

			if ($format == 'html')
			{
				echo View::make(Location::ajax('get/task_roles'))
					->with('roles', $task->roles);
			}
			else
			{
				echo $task->roles->toJson();
			}
		}
	}

	public function postUserSearch()
	{
		if (Sentry::check() 
				and Sentry::getUser()->allowed(['user.create', 'user.update', 'user.delete'], false))
		{
			// Get the query
			$query = e(Input::get('query'));

			// Find by name
			$name = \User::searchName($query)->get();

			// Find by email
			$email = \User::searchEmail($query)->get();

			// Find by character
			$character = \User::searchCharacters($query)->get();

			return json_encode([
				'name'			=> $name->toArray(),
				'email'			=> $email->toArray(),
				'characters'	=> $character->toArray(),
			]);
		}
	}

	/**
	 * Get the users who are assigned a given role.
	 */
	public function getUsersWithRole($id)
	{
		if (Sentry::check())
		{
			// Get the role
			$role = \AccessRole::find($id);

			echo View::make(Location::ajax('get/role_users'))
				->with('users', $role->users);
		}
	}

}