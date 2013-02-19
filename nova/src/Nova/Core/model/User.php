<?php
/**
 * User Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Model;
use Status;
use AppModel;
use LogModel;
use PostModel;
use CharacterModel;
use UserPrefsModel;
use AccessRoleModel;
use AppReviewerModel;
use AnnouncementModel;

class User extends Model {

	protected $table = 'users';

	protected $hidden = array(
		'password',
		'reset_password_hash',
		'activation_hash',
		'persist_hash',
		'ip_address'
	);
	
	protected static $properties = array(
		'id'					=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'status'				=> array('type' => 'tinyint', 'constraint' => 1, 'default' => Status::PENDING),
		'name'					=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'email'					=> array('type' => 'string', 'constraint' => 100, 'null' => true),
		'password'				=> array('type' => 'string', 'constraint' => 96, 'null' => true),
		'character_id'			=> array('type' => 'int', 'constraint' => 11, 'default' => 0),
		'role_id'				=> array('type' => 'int', 'constraint' => 11, 'default' => 0),
		'reset_password_hash'	=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'activation_hash'		=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'persist_hash'			=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'ip_address'			=> array('type' => 'string', 'constraint' => 16, 'null' => true),
		'leave_date'			=> array('type' => 'datetime', 'null' => true),
		'last_post'				=> array('type' => 'datetime', 'null' => true),
		'last_login'			=> array('type' => 'datetime', 'null' => true),
		'created_at'			=> array('type' => 'datetime', 'null' => true),
		'updated_at'			=> array('type' => 'datetime', 'null' => true),
	);
	
	/**
	 * Belongs To: Access Role
	 */
	public function role()
	{
		return $this->belongsTo('AccessRoleModel');
	}

	/**
	 * Has One: Main Character
	 */
	public function character()
	{
		return $this->hasOne('CharacterModel');
	}

	/**
	 * Has One: Application
	 */
	public function app()
	{
		return $this->hasOne('AppModel');
	}

	/**
	 * Has Many: Characters
	 */
	public function characters()
	{
		return $this->hasMany('CharacterModel');
	}

	/**
	 * Has Many: Personal Logs
	 */
	public function logs()
	{
		return $this->hasMany('LogModel');
	}

	/**
	 * Has Many: Announcements
	 */
	public function announcements()
	{
		return $this->hasMany('AnnouncementModel');
	}

	/**
	 * Has Many: User Preferences
	 */
	public function preferences()
	{
		return $this->hasMany('UserPrefsModel');
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
	 */
	public function appReviews()
	{
		return $this->belongsToMany('AppModel', 'application_reviewers');
	}

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\User' => array(
			'events' => array('after_insert', 'before_insert', 'after_update', 'before_delete')
		),
	);

	/**
	 * Status Accessor.
	 *
	 * Converts the integer-based status field to a string.
	 *
	 * @param	string	The field value
	 * @return	string
	 */
	public function getStatusAttribute($value)
	{
		return Status::toString($value);
	}

	/**
	 * Get the user's preferences.
	 *
	 * @param	string	Preference key to get
	 * @return	string
	 */
	public function getPreferenceItem($item = false)
	{
		// Filter the preferences based on what we want
		$pref = $this->preferences->filter(function($p) use($item)
		{
			return ($p->key == $item);
		});

		return $pref->first()->value;
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
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		if ($user !== null)
		{
			// Get the user
			$record = $query->where('id', $user)->first();
			
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
	 * Get every user based on criteria.
	 *
	 * @param	int		Status to pull
	 * @return	Collection
	 */
	public static function getItems($status = Status::ACTIVE)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->where('status', $status)->get();
	}
}
