<?php namespace Nova\Core\Model;

use Str;
use Date;
use Model;
use Event;
use Config;
use Status;
use Sentry;
use Session;
use Redirect;
use Exception;
use AccessRole;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Groups\GroupInterface;

class User extends Model implements UserInterface {

	protected $table = 'users';

	protected $fillable = array(
		'first_name', 'last_name', 'email', 'status', 'name', 'character_id',
		'role_id', 'password'
	);

	protected $hidden = array(
		'password', 'reset_password_hash', 'activation_hash', 'persist_hash',
		'ip_address'
	);

	protected $hashableAttributes = array('password', 'persist_code');

	protected $dates = array(
		'created_at', 'updated_at', 'leave_date', 'last_post', 'last_login'
	);
	
	protected static $properties = array(
		'id', 'status', 'name', 'email', 'password', 'character_id', 'role_id', 
		'reset_password_hash', 'activation_hash', 'persist_hash', 'ip_address', 
		'leave_date', 'last_post', 'last_login', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Belongs To: Access Role
	 */
	public function role()
	{
		return $this->belongsTo('AccessRole', 'role_id');
	}

	/**
	 * Has One: Application
	 */
	public function app()
	{
		return $this->hasOne('NovaApp', 'user_id');
	}

	/**
	 * Has Many: Characters
	 */
	public function characters()
	{
		return $this->hasMany('Character', 'user_id');
	}

	/**
	 * Has Many: Personal Logs
	 */
	public function logs()
	{
		return $this->hasMany('PersonalLog', 'user_id');
	}

	/**
	 * Has Many: Announcements
	 */
	public function announcements()
	{
		return $this->hasMany('Announcement', 'user_id');
	}

	/**
	 * Has Many: User Preferences
	 */
	public function preferences()
	{
		return $this->hasMany('UserPrefs', 'user_id');
	}

	/**
	 * Has Many: Throttles
	 */
	public function throttles()
	{
		return $this->hasMany('UserSuspend', 'user_id');
	}

	/**
	 * Has Many: Awards
	 */
	public function awards()
	{
		return $this->hasMany('AwardRecipient', 'user_id');
	}

	/**
	 * Belongs To Many: Posts (through Post Authors)
	 */
	public function posts()
	{
		return $this->belongsToMany('Post', 'post_authors');
	}

	/**
	 * Belongs To Many: Application Reviews (through Application Reviewers)
	 *
	 * BROKEN. WILL FIX LATER.
	 */
	public function appReviews()
	{
		return $this->belongsToMany('NovaApp', 'application_reviewers');
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to pending users.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopePending($query)
	{
		$query->where('status', Status::PENDING);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$classes = Config::get('app.aliases');

		Event::listen("eloquent.created: {$classes['User']}", "{$classes['UserHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['User']}", "{$classes['UserHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['User']}", "{$classes['UserHandler']}@beforeDelete");
		Event::listen("eloquent.saving: {$classes['User']}", "{$classes['UserHandler']}@beforeSave");
	}

	/**
	 * Is the user a system administrator?
	 *
	 * @return	bool
	 * @todo	Should we get rid of this preference altogether and use the role instead?
	 */
	public function isAdmin()
	{
		return (bool) ($this->getPreferenceItem('is_sysadmin'));
	}

	/**
	 * Get the user's application reviews.
	 *
	 * @param	int		Specific status to pull back
	 * @return	array
	 */
	public function getAppReviews($status = false)
	{
		// Setup the holding array
		$reviews = array();

		if ($this->appReviews)
		{
			// Loop through the user's reviews
			foreach ($this->appReviews as $r)
			{
				$reviews[$r->status][] = $r;
			}

			if ($status)
			{
				return $reviews[$status];
			}

			return $reviews;
		}

		return false;
	}

	/**
	 * Get the user's preferences.
	 *
	 * @param	string	Preference key to get
	 * @return	string
	 */
	public function getPreferenceItem($item = false)
	{
		$prefs = $this->preferences->toSimpleArray('key', 'value');

		return $prefs[$item];
	}

	/**
	 * Get the user's primary character.
	 *
	 * @return	Character
	 */
	public function getPrimaryCharacter()
	{
		return $this->characters->find($this->character_id);
	}

	/**
	 * Update the status of the user.
	 *
	 * @param	string	Status to change to
	 * @return	void
	 */
	public function updateStatus($status)
	{
		switch ($status)
		{
			case 'activate':
				$this->status = Status::ACTIVE;
			break;

			case 'deactivate':
				$this->status = Status::INACTIVE;
			break;

			case 'remove':
				$this->status = Status::REMOVED;
			break;
		}

		$this->save();
	}

	/**
	 * Update a user.
	 *
	 * @param	int		The user ID to update, if nothing is provided, it will update all users
	 * @param	array 	A data array to use for updating the record
	 * @return	User|void
	 */
	public static function updateUser($user, array $data)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		if ($user !== null)
		{
			// Get the user
			$record = $query->find($user);
			
			// Loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				$record->$key = $value;
			}
			
			$record->save();
			
			return $record;
		}
		else
		{
			// Pull everything from the table
			$records = $query->get();
			
			// Loop through all the records
			foreach ($records as $r)
			{
				// Loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					$r->$key = $value;
				}
				
				$r->save();
			}
		}
	}

	/**
	 * Repopulate the session data.
	 *
	 * @return	void
	 */
	public function populateSession()
	{
		// Loop through the prefs and put them into the session
		foreach ($this->preferences as $pref)
		{
			Session::put($pref->key, $pref->value);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry User Interface Methods
	|--------------------------------------------------------------------------
	|
	| Sentry provides an interface of methods that need to be implemented by
	| the model. In Nova's case, some of these aren't applicable, and in those
	| situations, we simply throw exceptions. In others, we do things the way
	| we've chosen to setup our authorization system.
	|
	*/
	
	/**
	 * Returns the user's ID.
	 *
	 * @return	int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the name for the user's login.
	 *
	 * @return	string
	 */
	public function getLoginName()
	{
		return 'email';
	}

	/**
	 * Returns the user's login.
	 *
	 * @return	string
	 */
	public function getLogin()
	{
		return $this->email;
	}

	/**
	 * Returns the name for the user's password.
	 *
	 * @return string
	 */
	public function getPasswordName()
	{
		return 'password';
	}

	/**
	 * Returns the user's password (hashed).
	 *
	 * @return	string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Returns permissions for the user.
	 *
	 * @return	array
	 */
	public function getPermissions()
	{
		return $this->getMergedPermissions();
	}

	/**
	 * Check if the user is activated.
	 *
	 * @return	bool
	 */
	public function isActivated()
	{
		return ((int) $this->status === Status::ACTIVE);
	}

	/**
	 * Checks if the user is a super user - has access to everything regardless
	 * of permissions.
	 *
	 * @return	bool
	 */
	public function isSuperUser()
	{
		return $this->isAdmin();
	}

	/**
	 * Validates the user and throws a number of exceptions if validation fails.
	 *
	 * @throws	Exception
	 */
	public function validate()
	{
		throw new Exception("User validation is not supported in Citadel.");
	}

	/**
	 * Delete the user.
	 *
	 * We don't ever actually delete a user, we only hide them.
	 *
	 * @return	bool
	 */
	public function delete()
	{
		$this->status = Status::REMOVED;
		$this->save();

		return true;
	}

	/**
	 * Gets a code for when the user is persisted to a cookie or session which
	 * identifies the user.
	 *
	 * @return	string
	 */
	public function getPersistCode()
	{
		$this->persist_hash = Str::random(42);

		// Our code got hashed
		$persistCode = $this->persist_hash;

		$this->save();

		return $persistCode;
	}

	/**
	 * Checks the given persist code.
	 *
	 * @param	string	The persist code to check
	 * @return	bool
	 */
	public function checkPersistCode($persistCode)
	{
		if ( ! $persistCode)
		{
			return false;
		}

		return $persistCode == $this->persist_hash;
	}

	/**
	 * Get an activation code for the given user.
	 *
	 * @throws	Exception
	 */
	public function getActivationCode()
	{
		throw new Exception("Activation is not supported in Citadel.");
	}

	/**
	 * Attempts to activate the given user by checking the activate code. If the
	 * user is activated already, an exception is thrown.
	 *
	 * @throws	Exception
	 */
	public function attemptActivation($activationCode)
	{
		throw new Exception("Activation is not supported in Citadel.");
	}

	/**
	 * Get a reset password code for the given user.
	 *
	 * @return	string
	 */
	public function getResetPasswordCode()
	{
		$this->reset_password_hash = Str::random(42);

		// Our code got hashed
		$resetCode = $this->reset_password_hash;

		$this->save();

		return $resetCode;
	}

	/**
	 * Checks the password passed matches the user's password.
	 *
	 * @param  string  $password
	 * @return bool
	 */
	public function checkPassword($password)
	{
		return $this->checkHash($password, $this->getPassword());
	}

	/**
	 * Checks if the provided user reset password code is valid without actually
	 * resetting the password.
	 *
	 * @param	string	The reset code to test
	 * @return	bool
	 */
	public function checkResetPasswordCode($resetCode)
	{
		return ($this->reset_password_hash == $resetCode);
	}

	/**
	 * Attemps to reset a user's password by matching the reset code generated
	 * with the user's.
	 *
	 * @param	string	The reset code
	 * @param	string	The new password
	 * @return	bool
	 */
	public function attemptResetPassword($resetCode, $newPassword)
	{
		if ($this->checkResetPasswordCode($resetCode))
		{
			$this->password = $newPassword;
			$this->reset_password_hash = null;
			
			return $this->save();
		}

		return false;
	}

	/**
	 * Wipes out the data associated with resetting a password.
	 *
	 * @return	void
	 */
	public function clearResetPassword()
	{
		if ($this->reset_password_hash)
		{
			$this->reset_password_hash = null;
			
			$this->save();
		}
	}

	/**
	 * Returns the role the user is assigned.
	 *
	 * @param	bool	Get the full object?
	 * @return	object|string
	 */
	public function getGroups($getObject = false)
	{
		if ($getObject)
		{
			return $this->role;
		}

		return $this->role->name;
	}

	/**
	 * Adds the user to the given group
	 *
	 * @param	Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return	bool
	 */
	public function addGroup(GroupInterface $group)
	{
		$this->role_id = $group->id;
		$this->save();
	}

	/**
	 * Removes the user from the given group.
	 *
	 * @param	Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return	bool
	 */
	public function removeGroup(GroupInterface $group)
	{
		throw new Exception("Removing a user from a role is not supported in Citadel.");
	}

	/**
	 * See if the user is in the given group.
	 *
	 * @param	Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return	bool
	 */
	public function inGroup(GroupInterface $group)
	{
		return $this->hasRole($group->id, true);
	}

	/**
	 * Returns an array of merged permissions for each group the user is in.
	 *
	 * @return	array
	 */
	public function getMergedPermissions()
	{
		// Get the roles from the session
		$roles = Session::get('role');
		
		// If we don't have anything in the session, calculate the roles
		if ($roles === null)
		{
			// Set up an empty array for storing all the role tasks
			$roles = array();
			
			// Loop through the primary role's tasks and add them
			foreach ($this->role->tasks as $task)
			{
				if ((isset($roles[$task->component][$task->action]) 
						and $roles[$task->component][$task->action] < (int) $task->level)
						or ! isset($roles[$task->component][$task->action]))
				{
					$roles[$task->component][$task->action] = (int) $task->level;
				}
			}
			
			// Loop through the inherited roles
			foreach ($this->role->inherits as $i)
			{
				// Make sure we aren't doing anything stupid
				if ($i > 0 and $i !== null)
				{
					// Get the role
					$r = AccessRole::find($i);
					
					// Loop through the role's tasks and add them
					foreach ($r->tasks as $t)
					{
						if ((isset($roles[$t->component][$t->action]) 
								and $roles[$t->component][$t->action] < (int) $t->level)
								or ! isset($roles[$t->component][$t->action]))
						{
							$roles[$t->component][$t->action] = (int) $t->level;
						}
					}
				}
			}

			// Put the role info into the session
			Session::put('role', $roles);

			// Touch the updated_at timestamp
			$this->updated_at = $this->freshTimestamp();
			$this->save();
		}
		
		return $roles;
	}

	/**
	 * See if a user has access to the passed permission(s). Permissions are
	 * merged from all groups the user belongs to and then are checked against
	 * the passed permission(s).
	 *
	 * @param	string	Dot-notated component-action item
	 * @return	bool
	 */
	public function hasAccess($permissions, $all = true)
	{
		$mergedPermissions = $this->getMergedPermissions();

		return (array_get($mergedPermissions, $permissions, false) !== false);
	}

	/**
	 * See if a user has access to the passed permission(s).
	 * Permissions are merged from all groups the user belongs to
	 * and then are checked against the passed permission(s).
	 *
	 * If multiple permissions are passed, the user must
	 * have access to all permissions passed through, unless the
	 * "all" flag is set to false.
	 *
	 * Super users DON'T have access no matter what.
	 *
	 * @param  string|array  $permissions
	 * @param  bool $all
	 * @return bool
	 */
	public function hasPermission($permissions, $all = true)
	{
		$mergedPermissions = $this->getMergedPermissions();

		if ( ! is_array($permissions))
		{
			$permissions = (array) $permissions;
		}

		foreach ($permissions as $permission)
		{
			// We will set a flag now for whether this permission was
			// matched at all.
			$matched = true;

			// Now, let's check if the permission ends in a wildcard "*" symbol.
			// If it does, we'll check through all the merged permissions to see
			// if a permission exists which matches the wildcard.
			if ((strlen($permission) > 1) and ends_with($permission, '*'))
			{
				$matched = false;

				foreach ($mergedPermissions as $mergedPermission => $value)
				{
					// Strip the '*' off the end of the permission.
					$checkPermission = substr($permission, 0, -1);

					// We will make sure that the merged permission does not
					// exactly match our permission, but starts wtih it.
					if ($checkPermission != $mergedPermission and starts_with($mergedPermission, $checkPermission) and $value == 1)
					{
						$matched = true;
						break;
					}
				}
			}

			else
			{
				$matched = false;

				foreach ($mergedPermissions as $mergedPermission => $value)
				{
					// This time check if the mergedPermission ends in wildcard "*" symbol.
					if ((strlen($mergedPermission) > 1) and ends_with($mergedPermission, '*'))
					{
						$matched = false;

						// Strip the '*' off the end of the permission.
						$checkMergedPermission = substr($mergedPermission, 0, -1);

						// We will make sure that the merged permission does not
						// exactly match our permission, but starts wtih it.
						if ($checkMergedPermission != $permission and starts_with($permission, $checkMergedPermission) and $value == 1)
						{
							$matched = true;
							break;
						}
					}

					// Otherwise, we'll fallback to standard permissions checking where
					// we match that permissions explicitly exist.
					elseif ($permission == $mergedPermission and $mergedPermissions[$permission] == 1)
					{
						$matched = true;
						break;
					}
				}
			}

			// Now, we will check if we have to match all
			// permissions or any permission and return
			// accordingly.
			if ($all === true and $matched === false)
			{
				return false;
			}
			elseif ($all === false and $matched === true)
			{
				return true;
			}
		}

		if ($all === false)
		{
			return false;
		}

		return true;
	}

	/**
	 * Returns if the user has access to any of the
	 * given permissions.
	 *
	 * @param  array  $permissions
	 * @return bool
	 */
	public function hasAnyAccess(array $permissions)
	{
		return true;
	}

	/**
	 * Records a login for the user.
	 *
	 * @return void
	 */
	public function recordLogin()
	{
		$this->last_login = $this->freshTimestamp();
		$this->save();
	}

	/**
	 * Checks if the user has at least the given role or higher.
	 *
	 * @param	int		The role ID
	 * @param	bool	Should it be a strict comparison (must equal) or not (greater than or equal)
	 * @return	bool
	 */
	public function hasRole($role, $strict = false)
	{
		if ($strict)
		{
			return ((int) $this->role_id === (int) $role);
		}

		return ((int) $this->role_id >= (int) $role);
	}

	/**
	 * Check if the user is allowed to access a page.
	 *
	 * @param	mixed	An access key or an array of keys
	 * @param	bool	Should they be redirected
	 * @return	bool
	 */
	public function allowed($key, $redirect = false)
	{
		// Check the login
		if ( ! Sentry::check() and $redirect)
		{
			return Redirect::to('login/index/'.\Nova\Core\Controller\Login::NOT_LOGGED_IN);
		}
		else
		{
			// If we have a simple string, make it an array
			if ( ! is_array($key))
			{
				$key = (array) $key;
			}

			// Create a temp array
			$allowed = array();

			// Loop through the array and see if they have access
			foreach ($key as $k)
			{
				$allowed[] = $this->hasAccess($k);
			}

			if ($redirect and ! in_array(true, $allowed))
			{
				return Redirect::to('admin/error/'.\Nova\Core\Controller\Admin\Main::NOT_ALLOWED);
			}
			
			return (in_array(true, $allowed));
		}

		return false;
	}

	/**
	 * Checks if the user has the given level
	 *
	 * @param	string	A dot-notated array key of the task
	 * @param	int		The level to check for (default: 0)
	 * @param	bool	Strict (exactly the level) or loose (at least the level)
	 * @return	bool
	 */
	public function hasLevel($permissions, $level = 0, $strict = true)
	{
		// If they don't have permission, break out early
		if ($this->hasAccess($permissions) === false)
		{
			return false;
		}

		// Get the full list of permissions
		$mergedPermissions = $this->getMergedPermissions();

		// Check to see if the user has AT LEAST a level
		if ($strict)
		{
			return (array_get($mergedPermissions, $permissions, false) === $level);
		}

		// Check to see if the user has EXACTLY a level
		return (array_get($mergedPermissions, $permissions, false) >= $level);
	}

	/**
	 * Checks if the user has at least the given level
	 *
	 * @param	string	A dot-notated array key of the task
	 * @param	int		The level to check for (default: 0)
	 * @return	bool
	 */
	public function hasAtLeastLevel($permissions, $level = 0)
	{
		return $this->hasLevel($permissions, $level, false);
	}

	/**
	 * Check string against hashed string.
	 *
	 * @param  string  $string
	 * @param  string  $hashedString
	 * @return bool
	 * @throws RuntimeException
	 */
	public function checkHash($string, $hashedString)
	{
		if ( ! static::$hasher)
		{
			throw new \RuntimeException("A hasher has not been provided for the user.");
		}

		return static::$hasher->checkHash($string, $hashedString);
	}

	/**
	 * Returns an array of hashable attributes.
	 *
	 * @return array
	 */
	public function getHashableAttributes()
	{
		return $this->hashableAttributes;
	}
	
}