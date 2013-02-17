<?php
/**
 * User Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Status;

class User extends \Model {

	protected $table = 'users';

	protected $hidden = array(
		'password',
		'password_reset_hash',
		'temp_password',
		'remember_me',
		'ip_address'
	);
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::PENDING),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'password' => array(
			'type' => 'string',
			'constraint' => 96,
			'null' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'role_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'password_reset_hash' => array(
			'type' => 'string',
			'constraint' => 24,
			'null' => true),
		'temp_password' => array(
			'type' => 'string',
			'constraint' => 96,
			'null' => true),
		'remember_me' => array(
			'type' => 'string',
			'constraint' => 24,
			'null' => true),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'null' => true),
		'leave_date' => array(
			'type' => 'datetime',
			'null' => true),
		'last_post' => array(
			'type' => 'datetime',
			'null' => true),
		'last_login' => array(
			'type' => 'datetime',
			'null' => true),
		'created_at' => array(
			'type' => 'datetime',
			'null' => true),
		'updated_at' => array(
			'type' => 'datetime',
			'null' => true),
	);
	
	/**
	 * Relationships
	 */
	protected static $_belongs_to = array(
		'role' => array(
			'model_to' => '\\Model_Access_Role',
			'key_to' => 'id',
			'key_from' => 'role_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	protected static $_has_one = array(
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'app' => array(
			'key_from' => 'id',
			'model_to' => '\\Model_Application',
			'key_to' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	protected static $_has_many = array(
		'characters' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'logs' => array(
			'model_to' => '\\Model_PersonalLog',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'announcements' => array(
			'model_to' => '\\Model_Announcement',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'preferences' => array(
			'model_to' => '\\Model_User_Preferences',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	protected static $_many_many = array(
		'posts' => array(
			'model_to' => '\\Model_Post',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'user_id',
			'key_through_to' => 'post_id',
			'table_through' => 'post_authors',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'appReviews' => array(
			'model_to' => '\\Model_Application',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'user_id',
			'key_through_to' => 'app_id',
			'table_through' => 'application_reviewers',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\User' => array(
			'events' => array('after_insert', 'before_insert', 'after_update', 'before_delete')
		),
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	/**
	 * Get the user's preferences.
	 *
	 * @api
	 * @param	string	a specific item to grab
	 * @return	array
	 */
	public function getPreferences($item = false)
	{
		// Set up a blank array for storing the items
		$prefs = array();
		
		// Loop through the preferences
		foreach ($this->preferences as $p)
		{
			$prefs[$p->key] = $p->value;
		}

		if ($item)
		{
			return $prefs[$item];
		}
		
		return $prefs;
	}

	/**
	 * Get the user's application reviews.
	 *
	 * @api
	 * @param	int		a specific status to pull back
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
	 * Get every user based on criteria.
	 *
	 * @api
	 * @param	int		the status to pull
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->where('status', $status)->get();
	}
	
	/**
	 * Update the status of the user.
	 *
	 * @api
	 * @param	string	the status to change to
	 * @return	void
	 */
	public function updateStatus($status)
	{
		switch ($status)
		{
			case 'activate':
				$this->status = \Status::ACTIVE;
			break;

			case 'deactivate':
				$this->status = \Status::INACTIVE;
			break;

			case 'remove':
				$this->status = \Status::REMOVED;
			break;
		}

		// Save the user
		$this->save();
	}
	
	/**
	 * Update a user.
	 *
	 * @api
	 * @param	int		the user ID to update, if nothing is provided, it will update all users
	 * @param	array 	a data array to use for updating the record
	 * @return	object
	 */
	public static function updateUser($user, array $data)
	{
		if ($user !== null)
		{
			// Get the user
			$record = static::find($user);
			
			// Loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				$record->$key = $value;
			}
			
			// Save the record
			$record->save();
			
			return $record;
		}
		else
		{
			// Pull everything from the table
			$records = static::all();
			
			// Loop through all the records
			foreach ($records as $r)
			{
				// Loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					$r->$key = $value;
				}
				
				// Save the record
				$r->save();
			}
		}
	}

	public function getStatusAttribute($value)
	{
		return Status::toString($value);
	}
}
