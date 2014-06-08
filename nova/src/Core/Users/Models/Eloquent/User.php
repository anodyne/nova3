<?php namespace Nova\Core\Users\Models\Eloquent;

use App;
use Str;
use Date;
use Model;
use Event;
use Config;
use Status;
use Sentry;
use Request;
use Session;
use Gravatar;
use Location;
use Redirect;
use ErrorCode;
use Exception;
use MediaModel;
use DynamicForm;
use FormDataModel;
use SettingsModel;
use MediaInterface;
use UserPrefsModel;
use AccessRoleModel;
use FormDataInterface;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Groups\GroupInterface;
use Cartalyst\Sentry\Groups\GroupableInterface;
use Cartalyst\Sentry\Permissions\PermissibleInterface;
//use Cartalyst\Sentry\Persistence\PersistableInterface;

use Nova\Aegis\Persistence\PersistableInterface;

class User extends Model implements PersistableInterface, FormDataInterface, MediaInterface {

	protected $table = 'users';

	protected $fillable = [
		'status', 'name', 'email', 'password', 'character_id',
		'reset_password_hash', 'activation_hash', 'persistence_codes', 'ip_address',
		'leave_date', 'last_post', 'last_login',
	];

	protected $hidden = [
		'password', 'reset_password_hash', 'activation_hash', 'persistence_codes',
		'ip_address',
	];

	protected $hashableAttributes = ['password'];

	protected $dates = [
		'created_at', 'updated_at', 'leave_date', 'last_post', 'last_login',
		'activated_at',
	];
	
	protected static $properties = [
		'id', 'status', 'name', 'email', 'password', 'character_id', 
		'reset_password_hash', 'activation_hash', 'persistence_codes', 'ip_address', 
		'leave_date', 'last_post', 'last_login', 'created_at', 'updated_at',
		'activated_at',
	];

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Has Many: Access Role
	 */
	public function roles()
	{
		return $this->belongsToMany('AccessRoleModel', 'users_roles', 'user_id', 'role_id');
	}

	/**
	 * Has One: Application
	 */
	public function app()
	{
		return $this->hasOne('ApplicationModel', 'user_id');
	}

	/**
	 * Has Many: Characters
	 */
	public function characters()
	{
		return $this->hasMany('CharacterModel', 'user_id');
	}

	/**
	 * Has Many: Personal Logs
	 */
	public function logs()
	{
		return $this->hasMany('PersonalLogModel', 'user_id');
	}

	/**
	 * Has Many: Announcements
	 */
	public function announcements()
	{
		return $this->hasMany('AnnouncementModel', 'user_id');
	}

	/**
	 * Has Many: User Preferences
	 */
	public function preferences()
	{
		return $this->hasMany('UserPrefsModel', 'user_id');
	}

	/**
	 * Has Many: Throttles
	 */
	public function throttles()
	{
		return $this->hasMany('UserSuspendModel', 'user_id');
	}

	/**
	 * Has Many: Awards
	 */
	public function awards()
	{
		return $this->hasMany('AwardRecipientModel', 'user_id');
	}

	/**
	 * Has Many: User Data
	 */
	public function data()
	{
		return $this->hasMany('FormDataModel', 'data_id')->where('form_id', 2);
	}

	/**
	 * Has Many: FormViewer Records
	 */
	public function formviewer()
	{
		return $this->hasMany('FormDataModel', 'created_by');
	}

	/**
	 * Belongs To Many: Posts (through Post Authors)
	 */
	public function posts()
	{
		return $this->belongsToMany('PostModel', 'post_authors');
	}

	/**
	 * Belongs To Many: Application Reviews (through Application Reviewers)
	 *
	 * BROKEN. WILL FIX LATER.
	 */
	public function appReviews()
	{
		return $this->belongsToMany('ApplicationModel', 'application_reviewers');
	}

	public function persistence()
	{
		return $this->hasMany('UserPersistenceModel', 'user_id');
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
			->where(function($q) use ($value)
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
		$this->attributes['password'] = App::make('nova.aegis.hasher')->hash($value);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

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
	 * Can this user update a specific character?
	 *
	 * @param	Character	$character	The character attempting to be edited
	 * @return	bool
	 */
	public function canEditCharacter($character)
	{
		if ($this->hasLevel('character.update', 3))
			return true;

		// level 2

		if ($this->hasLevel('character.update', 1) and $user->getPrimaryCharacter()->id === $character->id)
			return true;

		return false;
	}

	/**
	 * Can this user update a specific user?
	 *
	 * @param	User	$user	The user attempting to be edited
	 * @return	bool
	 */
	public function canEditUser($user)
	{
		if ($this->hasLevel('user.update', 2))
			return true;

		if ($this->hasLevel('user.update', 1))
			if (is_numeric($user) and $user == $this->id)
				return true;
			elseif ($user->id == $this->id)
				return true;

		return false;
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
		return $this->deleteUser();
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
	 * Get the avatar source for use in a partial.
	 *
	 * @param	string	$size	The size of the avatar (lg, sm)
	 * @return	string
	 */
	public function getAvatar($size = 'lg')
	{
		if ((bool) $this->getPreferenceItem('use_gravatar'))
			if ($size == 'lg')
				return Gravatar::src($this->email, 200);
			elseif ($size == 'md')
				return Gravatar::src($this->email, 64);
			else
				return Gravatar::src($this->email, 32);

		// Get the media object
		$media = $this->getMedia();

		if ($media)
			return $this->getMedia()->getPathWithUrl('users', $size);

		return Location::image("avatar-{$size}.png", 'urlpath');
	}

	/**
	 * Get the dynamic form for the user.
	 *
	 * @param	bool	$editable	Do we want the editable version of the form?
	 * @return	string
	 */
	public function getDynamicForm($editable = false)
	{
		return DynamicForm::setup('user', $this->id, $editable)->build();
	}

	/**
	 * Get the media object for the user.
	 *
	 * @return	Media
	 */
	public function getMedia()
	{
		return MediaModel::type('user')->entry($this->id)->get()->last();
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
			'rank'					=> SettingsModel::getSettings('rank'),
			'skin_main'				=> SettingsModel::getSettings('skin_main'),
			'skin_admin'			=> SettingsModel::getSettings('skin_admin'),
			'use_gravatar'			=> (int) false,
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
			$this->preferences()->save(UserPrefsModel::create(['key' => $key, 'value' => $value]));
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
			if ($this->characters->count() > 0)
			{
				// Delete all characters associated with the user
				foreach ($this->characters as $character)
				{
					$character->deleteCharacter();
				}
			}

			// Delete the user
			return parent::delete();
		}
		else
		{
			if ($this->characters->count() > 0)
			{
				// Delete all characters associated with the user
				foreach ($this->characters as $character)
				{
					$character->deleteCharacter();
				}
			}

			// Update the user's status
			$this->updateStatus('remove');

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
			$pref = UserPrefsModel::key($key)->first();

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
				FormDataModel::create(array_merge($data, ['data_id' => $u->id]));
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Media Implementation
	|--------------------------------------------------------------------------
	*/

	public function addMedia($file, $options)
	{
		return MediaModel::create([
			'type'			=> 'user',
			'entry_id'		=> $this->id,
			'filename'		=> $file,
			'mime_type'		=> $options['mime_type'],
			'user_id'		=> $options['uploader'],
			'ip_address'	=> Request::getClientIp(),
		]);
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry UserInterface Implementation
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Get the user's primary key.
	 *
	 * @return int
	 */
	public function getUserId()
	{
		return $this->id;
	}

	/**
	 * Get the user's login.
	 *
	 * @return string
	 */
	public function getUserLogin()
	{
		return $this->email;
	}

	/**
	 * Get the user's login attribute name.
	 *
	 * @return string
	 */
	public function getUserLoginName()
	{
		return 'email';
	}

	/**
	 * Get the user's password.
	 *
	 * @return string
	 */
	public function getUserPassword()
	{
		return $this->password;
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry GroupableInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Return all associated groups.
	 *
	 * @return \IteratorAggregate
	 */
	public function getGroups()
	{
		return $this->role;
	}

	/**
	 * Return if the user is in the given group.
	 *
	 * @param  mixed  $group
	 * @return bool
	 */
	public function inGroup($group)
	{
		return $this->hasRole($group->id, true);

		$group = array_first($this->groups, function($index, $instance) use ($group)
		{
			if ($group instanceof GroupInterface)
			{
				return ($instance === $group);
			}

			if ($instance->getGroupId() == $group)
			{
				return true;
			}

			if ($instance->getGroupSlug() == $group)
			{
				return true;
			}

			return false;
		});

		return ($group !== null);
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry PermissableInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Returns a permissions instance.
	 *
	 * @return \Cartalyst\Sentry\Permissions\PermissionsInterface
	 */
	public function getPermissions()
	{
		return $this->getMergedPermissions();
	}

	/*
	|--------------------------------------------------------------------------
	| Aegis PersistableInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Generates a random persist code.
	 *
	 * @return string
	 */
	public function generatePersistenceCode()
	{
		return str_random(32);
	}

	/**
	 * Returns an array of assigned persist codes.
	 *
	 * @return array
	 */
	public function getPersistenceCodes()
	{
		return $this->persistence->toArray();
	}

	/**
	 * Adds a new persist code.
	 *
	 * @param  string  $code
	 * @return void
	 */
	public function addPersistenceCode($code)
	{
		$codes = $this->persistence_codes;
		$codes[] = $code;
		$this->persistence_codes = $codes;
	}

	/**
	 * Removes a persist code.
	 *
	 * @param  string  $code
	 * @return void
	 */
	public function removePersistenceCode($code)
	{
		$codes = $this->persistence_codes;

		$index = array_search($code, $codes);

		if ($index !== false)
		{
			unset($codes[$index]);
		}

		$this->persistence_codes = $codes;
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
					$r = AccessRoleModel::find($i);
					
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
				return Redirect::to('admin/error/'.ErrorCode::ADMIN_NOT_ALLOWED);
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
	
}