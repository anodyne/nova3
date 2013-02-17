<?php
/**
 * Part of the Sentry package for Nova.
 *
 * @package		Nova
 * @subpackage	Sentry
 * @category	Class
 * @author		Cartalyst LLC
 * @author		Anodyne Productions
 * @license		MIT License
 * @copyright	2011 Cartalyst LLC
 */

namespace Nova\Sentry;

use Lang;
use Date;
use Config;
use Cookie;
use Session;
use Utility;
use Redirect;
use UserModel;
use SystemModel;
use Fuel\Util\Str;
use AccessRoleModel;
use AccessTaskModel;

class SentryAuthException extends \Exception {}
class SentryAuthConfigException extends SentryAuthException {}

class Sentry {
	
	/**
	 * @var  bool  Whether suspension feature should be used or not
	 */
	protected static $suspend = null;

	/**
	 * @var  Sentry_Attempts  Holds the Sentry_Attempts object
	 */
	protected static $attempts = null;

	/**
	 * @var  object  Caches the current logged in user object
	 */
	protected static $currentUser = null;

	/**
	 * @var  array  Caches all users accessed
	 */
	protected static $userCache = array();

	/**
	 * Prevent instantiation
	 */
	final private function __construct() {}

	/**
	 * Get's either the currently logged in user or the specified user by id or
	 * login column value.
	 *
	 * @param	int|string	User ID or login column value to find
	 * @param	bool		Should the user be recached?
	 * @return	Sentry\User
	 */
	public static function user($id = null, $recache = false)
	{
		if ($id === null and $recache === false and static::$currentUser !== null)
		{
			return static::$currentUser;
		}
		elseif ($id !== null and $recache === false and isset(static::$userCache[$id]))
		{
			return static::$userCache[$id];
		}

		try
		{
			if ($id)
			{
				static::$userCache[$id] = new User($id);
				return static::$userCache[$id];
			}
			elseif (static::check())
			{
				$userId = Session::get('user');
				static::$currentUser = new User($userId);
				return static::$currentUser;
			}
		}
		catch (SentryUserNotFoundException $e)
		{
			return \Nova\Core\Controller\Login::WRONG_EMAIL;
		}

		return new User;
	}

	/**
	 * Get the currently logged in user's group object or the specified group
	 * by ID or name.
	 *
	 * @param	int|string	Group ID or name
	 * @return	Sentry\Group
	 */
	public static function group($id = null)
	{
		if ($id)
		{
			return new Group($id);
		}

		return new Group;
	}

	/**
	 * Get the Attempts object
	 *
	 * @return	Sentry\Attempts
	 */
	 public static function attempts($loginId = null, $ipAddress = null)
	 {
	 	return new Attempts($loginId, $ipAddress);
	 }

	/**
	 * Attempt to log a user in.
	 *
	 * @param	string	Login column value
	 * @param	string	Password entered
	 * @param	bool	Whether to remember the user or not
	 * @return	bool
	 * @throws	SentryAuthException
	 */
	public static function login($loginColumnValue, $password, $remember = false)
	{
		// Log the user out if they hit the login page
		static::logout();

		// Get login attempts
		if (static::$suspend)
		{
			$attempts = static::attempts($loginColumnValue, Utility::realIp());

			// If attempts > limit, suspend the login/IP combo
			if ($attempts->get() >= $attempts->getLimit())
			{
				try
				{
					$attempts->suspend();
				}
				catch(SentryUserSuspendedException $e)
				{
					// Get the user
					$u = UserModel::getItem($loginColumnValue, 'email');

					// Create an event
					\SystemEvent::add(false, '[[event.login.suspended|{{'.$u->name.'}}]]');
					
					return \Nova\Core\Controller\Login::SUSPEND_DURING;
				}
			}
		}

		// Make sure vars have values
		if (empty($loginColumnValue) or empty($password))
		{
			if (empty($loginColumnValue) and ! empty($password))
			{
				return \Nova\Core\Controller\Login::NO_EMAIL;
			}

			if ( ! empty($loginColumnValue) and empty($password))
			{
				return \Nova\Core\Controller\Login::NO_PASS;
			}

			return \Nova\Core\Controller\Login::WRONG_EMAIL_PASS;
		}
		
		// Validate the user
		$user = static::validateUser($loginColumnValue, $password, 'password');

		// If we have a user object, continue
		if ( ! is_numeric($user))
		{
			if (static::$suspend)
			{
				// Clear attempts for login since they got in
				$attempts->clear();
			}

			// Set update array
			$update = array();

			// If they wish to be remembered, set the cookie and get the hash
			if ($remember)
			{
				$update['remember_me'] = static::remember($loginColumnValue);
			}

			// If there is a password reset hash and user logs in, remove the password reset
			if ($user->get('password_reset_hash'))
			{
				$update['password_reset_hash'] = '';
				$update['temp_password'] = '';
			}
			
			$update['last_login'] = Date::now()->toDateTimeString();
			$update['ip_address'] = Utility::realIp();

			// Update user
			if (count($update))
			{
				UserModel::updateUser($user->get('id'), $update);
			}

			// Set session vars
			\Session::put('user', (int) $user->get('id'));
			\Session::put('role', $user->groups());
			\Session::put('preferences', UserModel::find($user->get('id'))->getPreferences());
			
			return \Nova\Core\Controller\Login::OK;
		}
		else
		{
			return $user;
		}

		return \Nova\Core\Controller\Login::UNKNOWN;
	}

	/**
	 * Force Login
	 *
	 * @param   int|string  user id or login value
	 * @param   provider    what system was used to force the login
	 * @return  bool
	 * @throws  SentryAuthException
	 */
	public static function forceLogin($id, $provider = 'Sentry-Forced')
	{
		// Check to make sure user exists
		if ( ! static::userExists($id))
		{
			throw new SentryAuthException(Lang::get('sentry.user_not_found'));
		}

		Session::put('user', $id);
		Session::put('role', $user->getUserRole());
		Session::put('preferences', UserModel::find($id)->getPreferences());
		
		return true;
	}

	/**
	 * Checks if the current user is logged in.
	 *
	 * @return  bool
	 */
	public static function check()
	{
		// Get session
		$userId = Session::get('user');
		
		// Invalid session values, kill the user session
		if ($userId === null or ! is_numeric($userId))
		{
			// If they are not logged in, check for cookie and log them in
			if (static::isRemembered())
			{
				return true;
			}

			// Else log out
			static::logout();

			return false;
		}

		return true;
	}

	/**
	 * Logs the current user out. Also invalidates the Remember Me setting.
	 *
	 * @return  void
	 */
	public static function logout()
	{
		// Remove the cookie for the remember me
		Cookie::forget(Config::get('sentry.remember_me.cookie_name'));
		
		// Delete the session info
		Session::forget('user');
		Session::forget('role');
		Session::forget('preferences');
	}

	/**
	 * Activate a user account
	 *
	 * @param   string  Encoded Login Column value
	 * @param   string  User's activation code
	 * @return  bool
	 * @throws  SentryAuthException
	 */
	public static function activateUser($loginColumnValue, $code, $decode = true)
	{
		// Decode login column
		if ($decode)
		{
			$loginColumnValue = base64_decode($loginColumnValue);
		}

		// Make sure vars have values
		if (empty($loginColumnValue) or empty($code))
		{
			return false;
		}

		// If user is validated
		if ($user = static::validateUser($loginColumnValue, $code, 'activation_hash'))
		{
			// Update pass to temp pass, reset temp pass and hash
			$user->update(array(
				'activation_hash' => '',
				'activated' => (int) true
			), false);

			return $user;
		}

		return false;
	}

	/**
	 * Starts the reset password process. Generates the necessary password
	 * reset hash and returns the new user array. Password reset confirm
	 * still needs called.
	 *
	 * @param   string  Login Column value
	 * @param   string  User's new password
	 * @return  bool|array
	 * @throws  SentryAuthException
	 */
	public static function resetPassword($loginColumnValue, $password)
	{
		// Make sure a user ID is set
		if (empty($loginColumnValue) or empty($password))
		{
			return false;
		}

		// Check if user exists
		$user = static::user($loginColumnValue);

		// Create a hash for resetPassword link
		$hash = Str::random('alnum', 24);

		// Set update values
		$update = array(
			'password_reset_hash' => $hash,
			'temp_password' => $password,
			'remember_me' => '',
		);

		// Save the user
		$save = UserModel::updateUser($user->get('id'), $update);

		// If database was updated return confirmation data
		if ($save)
		{
			$update = array(
				'email' => $user->get('email'),
				'password_reset_hash' => $hash,
				'link' => base64_encode($loginColumnValue).'/'.$update['password_reset_hash']
			);

			return $update;
		}
		
		return false;
	}

	/**
	 * Confirms a password reset code against the database.
	 *
	 * @param   string  Login Column value
	 * @param   string  Reset password code
	 * @return  bool
	 * @throws  SentryAuthException
	 */
	public static function resetPasswordConfirm($loginColumnValue, $code, $decode = true)
	{
		// Decode login column
		if ($decode)
		{
			$loginColumnValue = base64_decode($loginColumnValue);
		}

		// Make sure vars have values
		if (empty($loginColumnValue) or empty($code))
		{
			return false;
		}

		if (static::$suspend)
		{
			// Get login attempts
			$attempts = static::attempts($loginColumnValue, Utility::realIp());

			// If attempts > limit, suspend the login/IP combo
			if ($attempts->get() >= $attempts->getLimit())
			{
				$attempts->suspend();
			}
		}

		// Validate the user
		$user = static::validateUser($loginColumnValue, $code, 'password_reset_hash');

		// If user is validated
		if ($user)
		{
			$u = UserModel::find($user);
			$u->password = User::passwordHash($u->temp_password, SystemModel::getUniqueId());
			$u->password_reset_hash = null;
			$u->temp_password = null;
			$u->remember_me = null;
			$u->save();

			return true;
		}

		return false;
	}

	/**
	 * Checks if a user exists by Login Column value
	 *
	 * @param   string|id  Login column value or Id
	 * @return  bool
	 */
	public static function userExists($loginColumnValue)
	{
		try
		{
			$user = new User($loginColumnValue, true);

			if ($user)
			{
				return true;
			}
			else
			{
				// This should never happen...
				return false;
			}
		}
		catch (SentryUserNotFoundException $e)
		{
			return false;
		}
	}

	/**
	 * Checks if the group exists
	 *
	 * @param   string|int  Group name|Group id
	 * @return  bool
	 */
	public static function groupExists($group)
	{
		// Set the field to use
		$field = (is_int($group)) ? 'id' : 'name';
		
		return (bool) count(AccessRoleModel::getItem($group, $field));
	}

	/**
	 * Remember User Login
	 *
	 * @param int
	 */
	protected static function remember($loginColumn)
	{
		// Generate random string for cookie password
		$cookiePass = Str::random('alnum', 24);

		// create and encode string
		$cookieString = base64_encode($loginColumn.':'.$cookiePass);

		// Set cookie
		Cookie::put(
			Config::get('sentry.remember_me.cookie_name'),
			$cookieString,
			Config::get('sentry.remember_me.expire')
		);

		return $cookiePass;
	}

	/**
	 * Check if remember me is set and valid
	 */
	protected static function isRemembered()
	{
		$encodedVal = Cookie::get(Config::get('sentry.remember_me.cookie_name'));

		if ($encodedVal)
		{
			$val = base64_decode($encodedVal);
			list($loginColumn, $hash) = explode(':', $val);

			// If user is validated
			if ($user = static::validateUser($loginColumn, $hash, 'remember_me'))
			{
				// Update last login
				$user->update(array(
					'last_login' => Date::now()->toDateTimeString()
				));

				// Set session vars
				Session::put(Config::get('sentry.session.user'), (int) $user->get('id'));
				Session::put(Config::get('sentry.session.provider'), 'Sentry');

				return true;
			}
			else
			{
				static::logout();

				return false;
			}
		}

		return false;
	}

	/**
	 * Validates a Login and Password.  This takes a password type so it can be
	 * used to validate password reset hashes as well.
	 *
	 * @param   string  Login column value
	 * @param   string  Password to validate with
	 * @param   string  Field name (password type)
	 * @return  bool|Sentry_User
	 */
	protected static function validateUser($loginColumnValue, $password, $field)
	{
		// Get user
		$user = static::user($loginColumnValue);

		if (is_numeric($user))
		{
			return \Nova\Core\Controller\Login::WRONG_EMAIL;
		}
		
		// Check password
		if ( ! $user->checkPassword($password, $field))
		{
			if (static::$suspend and ($field == 'password' or $field == 'password_reset_hash'))
			{
				static::attempts($loginColumnValue, Utility::realIp())->add();
			}

			return \Nova\Core\Controller\Login::WRONG_PASS;
		}

		return $user;
	}

	/**
	 * Get's either the currently logged in user's role object or the
	 * specified role by id or name. Alias of group.
	 *
	 * @api
	 * @param   int|string  Role id or or name
	 * @return  Sentry_Group
	 */
	public static function role($id = null)
	{
		return static::group($id);
	}
	
	/**
	 * Checks if the role exists. Alias of groupExists.
	 *
	 * @api
	 * @param   string|int  Role name|Role id
	 * @return  bool
	 */
	public static function roleExists($role)
	{
		return static::groupExists($role);
	}

	/**
	 * Check if a user is allowed to access a page.
	 *
	 * @api
	 * @param	mixed	an access key or an array of keys
	 * @param	bool	should they be redirected
	 * @return	bool
	 */
	public static function allowed($key, $redirect = false)
	{
		// Check the login
		if (static::check() === false and $redirect === true)
		{
			Redirect::to('login/index/'.\Nova\Core\Controller\Login::NOT_LOGGED_IN);
		}
		else
		{
			// Get the current user
			$user = static::user();

			// If we have a simple string, make it an array
			if ( ! is_array($key))
			{
				$key = array($key);
			}

			// Create a temp array
			$allowed = array();

			// Loop through the array and see if they have access
			foreach ($key as $k)
			{
				$allowed[] = $user->hasAccess($k);
			}

			if ($redirect === true)
			{
				if ( ! in_array(true, $allowed))
				{
					Redirect::to('admin/error/'.\Nova\Core\Controller\Admin::NOT_ALLOWED);
				}

				return true;
			}
			
			return (in_array(true, $allowed));
		}

		return false;
	}

	/**
	 * Get a complete list of users that have access to a specific task.
	 *
	 * @api
	 * @param	string	a period-delimited string for an access task (component.action.level)
	 * @return	array
	 */
	public static function usersWithAccess($value)
	{
		// Get the task
		$task = AccessTaskModel::getTask($value);

		// Get any role that DIRECTLY has this task
		$direct = $task->roles;

		// Get any role that INDIRECTLY has this task
		$indirect = AccessRoleModel::query()
			->or_where('inherits', 'LIKE', "%,$task->id,%")
			->or_where('inherits', 'LIKE', "$task->id,%")
			->or_where('inherits', 'LIKE', "%,$task->id")
			->get();

		// Merge the two arrays
		$roles = array_merge($direct, $indirect);

		// Start the users array
		$users = array();

		// Loop through each role
		foreach ($roles as $r)
		{
			// Now loop through the role's users
			foreach ($r->users as $u)
			{
				$users[$u->id] = $u;
			}
		}

		return $users;
	}
}
