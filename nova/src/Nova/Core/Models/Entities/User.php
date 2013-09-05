<?php namespace Nova\Core\Models\Entities;

use App;
use Str;
use Date;
use Model;
use Event;
use Config;
use Status;
use Sentry;
use Session;
use Redirect;
use ErrorCode;
use Exception;
use UserPrefs;
use AccessRole;
use RankCatalog;
use NovaFormData;
use FormDataInterface;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Groups\GroupInterface;

class User extends Model implements UserInterface, FormDataInterface {

	protected $table = 'users';

	protected $fillable = array(
		'status', 'name', 'email', 'password', 'character_id', 'role_id',
		'reset_password_hash', 'activation_hash', 'persist_hash', 'ip_address',
		'leave_date', 'last_post', 'last_login',
	);

	protected $hidden = array(
		'password', 'reset_password_hash', 'activation_hash', 'persist_hash',
		'ip_address',
	);

	protected $hashableAttributes = array('password', 'persist_code');

	protected $dates = array(
		'created_at', 'updated_at', 'leave_date', 'last_post', 'last_login',
		'activated_at',
	);
	
	protected static $properties = array(
		'id', 'status', 'name', 'email', 'password', 'character_id', 'role_id', 
		'reset_password_hash', 'activation_hash', 'persist_hash', 'ip_address', 
		'leave_date', 'last_post', 'last_login', 'created_at', 'updated_at',
		'activated_at',
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
	 * Has Many: User Data
	 */
	public function data()
	{
		return $this->hasMany('NovaFormData', 'data_id')->where('form_id', 2);
	}

	/**
	 * Has Many: FormViewer Records
	 */
	public function formviewer()
	{
		return $this->hasMany('NovaFormData', 'created_by');
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
	 * Scope the query to user email address.
	 *
	 * @param	Builder		The query builder
	 * @param	string		Email address
	 * @return	void
	 */
	public function scopeEmail($query, $email)
	{
		$query->where('email', $email);
	}

	/**
	 * Scope the query to find by character.
	 *
	 * @param	Builder		The query builder
	 * @param	string		Character name
	 * @return	void
	 */
	public function scopeSearchCharacters($query, $value)
	{
		$query->join('characters', 'users.id', '=', 'characters.id')
			->where(function($q)
			{
				$q->where('characters.status', '=', Status::ACTIVE)
					->orWhere('characters.status', '=', Status::INACTIVE);
			})
			->where(function($q) use($value)
			{
				$q->where('characters.first_name', 'like', "%{$value}%")
					->orWhere('characters.last_name', 'like', "%{$value}%");
			});
	}

	/**
	 * Scope the query to find by email.
	 *
	 * @param	Builder		The query builder
	 * @param	string		Email address
	 * @return	void
	 */
	public function scopeSearchEmail($query, $value)
	{
		$query->where('email', 'like', $value);
	}

	/**
	 * Scope the query to find by name.
	 *
	 * @param	Builder		The query builder
	 * @param	string		Name
	 * @return	void
	 */
	public function scopeSearchName($query, $value)
	{
		$query->where('name', 'like', $value);
	}

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
	| Model Accessors
	|--------------------------------------------------------------------------
	*/

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = App::make('sentry.hasher')->hash($value);
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
		$a = Config::get('app.aliases');

		// Setup the listeners
		static::setupEventListeners($a['User'], $a['UserEventHandler']);
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
	 * Can this user be deleted?
	 *
	 * @return	bool
	 */
	public function canBeDeleted()
	{
		// Does the user have posts?
		if ($this->posts->count() > 0) return false;

		// Does the user have personal logs?
		if ($this->logs->count() > 0) return false;

		// Does the user have announcements?
		if ($this->announcements->count() > 0) return false;

		// Does the user have any awards?
		if ($this->awards->count() > 0) return false;

		// Does the user have any app reviews?
		//if ($this->appReviews->count() > 0) return false;

		// Forum posts

		// Wiki pages

		return true;
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
	 * Repopulate the session data.
	 *
	 * @return	void
	 */
	public function populateSession()
	{
		foreach ($this->preferences as $pref)
		{
			Session::put($pref->key, $pref->value);
		}
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
	 * Create the default user settings.
	 *
	 * @return	void
	 */
	public function createUserPreferences()
	{
		$insert = [
			'is_sysadmin'			=> (int) false,
			'is_game_master'		=> (int) false,
			'loa'					=> 'active',
			'timezone'				=> 'UTC',
			'language'				=> 'en',
			'rank'					=> Settings::getSettings('rank'),
			'skin_main'				=> Settings::getSettings('skin_main'),
			'skin_admin'			=> Settings::getSettings('skin_admin'),
			'email_format'			=> 'html',
			'email_comments'		=> (int) true,
			'email_messages'		=> (int) true,
			'email_logs'			=> (int) true,
			'email_announcements'	=> (int) true,
			'email_posts'			=> (int) true,
			'email_posts_save'		=> (int) true,
			'email_posts_delete'	=> (int) true,
		];

		foreach ($insert as $key => $value)
		{
			$this->preferences()->save(UserPrefs::create(['key' => $key, 'value' => $value]));
		}
	}

	/**
	 * Delete a user.
	 *
	 * In addition to deleting the user, this will also delete all characters
	 * associated with the user.
	 *
	 * @return	bool
	 */
	public function deleteUser()
	{
		if ($this->canBeDeleted())
		{
			// Delete all characters associated with the user
			foreach ($this->characters as $character)
			{
				$character->deleteCharacter();
			}

			// Delete the user
			$this->delete();

			return true;
		}
		else
		{
			// Delete all characters associated with the user
			foreach ($this->characters as $character)
			{
				$character->deleteCharacter();
			}

			// The user can't be deleted, so we'll just hide them
			$this->status = Status::REMOVED;
			$this->save();

			return true;
		}
	}

	/**
	 * Update user preferences.
	 *
	 * @param	array	Key-value pair for updating preferences
	 * @return	void
	 */
	public function updateUserPreferences(array $values)
	{
		foreach ($values as $key => $value)
		{
			// Find the preference
			$pref = UserPrefs::key($key)->first();

			// Update the preference
			$pref->update(['value' => $value]);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| FormDataInterface Implementation
	|--------------------------------------------------------------------------
	*/

	public static function createFieldData(array $data)
	{
		// Start a new query
		$query = static::startQuery();

		// Get all the active characters
		$users = $query->get();

		if ($users->count() > 0)
		{
			foreach ($users as $u)
			{
				NovaFormData::create(array_merge($data, ['data_id' => $u->id]));
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry UserInterface Implementation
	|--------------------------------------------------------------------------
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
		$this->deleteUser();

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
			// Put the intended desintation into the session
			Session::put('url.intended', App::make('url')->full());

			return Redirect::to('login/error/'.ErrorCode::LOGIN_NOT_LOGGED_IN);
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
				return Redirect::to('admin/error/'.\Nova\Core\Controllers\Admin\Main::NOT_ALLOWED);
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