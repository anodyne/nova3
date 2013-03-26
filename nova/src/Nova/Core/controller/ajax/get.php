<?php
/**
 * Nova's ajax controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Ajax_Get extends Controller_Base_Ajax
{
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
}
