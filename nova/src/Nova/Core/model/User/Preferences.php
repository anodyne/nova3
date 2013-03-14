<?php namespace Nova\Core\Model\User;

use Model;
use UserModel;
use RankCatalogModel;
use SkinSectionCatalogModel;

class Preferences extends Model {
	
	public $timestamps = false;
	
	protected $table = 'user_preferences';
	
	protected static $properties = array(
		'id', 'user_id', 'key', 'value',
	);
	
	/**
	 * Belongs To: User
	 *
	 * @return	User
	 */
	public function user()
	{
		return $this->belongsTo('UserModel');
	}
	
	/**
	 * Create the default user settings.
	 *
	 * @param	int		The user ID
	 * @return	Preferences
	 */
	public static function createUserPreferences($user)
	{
		$insert = array(
			'is_sysadmin'			=> (int) false,
			'is_game_master'		=> (int) false,
			'is_firstlaunch'		=> (int) true,
			'loa'					=> 'active',
			'timezone'				=> 'UTC',
			'email_format'			=> 'html',
			'language'				=> 'en',
			'rank'					=> RankCatalogModel::getDefault(true),
			'skin_main'				=> SkinSectionCatalogModel::getDefault('main', true),
			'skin_admin'			=> SkinSectionCatalogModel::getDefault('admin', true),
			'email_comments'		=> (int) true,
			'email_messages'		=> (int) true,
			'email_logs'			=> (int) true,
			'email_announcements'	=> (int) true,
			'email_posts'			=> (int) true,
			'email_posts_save'		=> (int) true,
			'email_posts_delete'	=> (int) true,
		);

		foreach ($insert as $key => $value)
		{
			// Create a new record
			$record = new static;

			// Set the key and value
			$record->user_id = $user;
			$record->key = $key;
			$record->value = $value;

			$record->save();
		}
		
		return $record;
	}

	/**
	 * Update the user preferences.
	 *
	 * @param 	int 	The user ID
	 * @param 	array 	An array of data to use
	 * @return 	bool
	 */
	public static function updateUserPreferences($id, array $data)
	{
		// Start a new query
		$query = static::startQuery();

		// Load the items
		$items = $query->where('user_id', $id)->get();

		// Set the count to 0
		$count = 0;

		foreach ($items as $i)
		{
			// If we've got the item in the array, update it
			if (array_key_exists($i->key, $data))
			{
				// Update the value
				$i->value = \e($data[$i->key]);

				// Save the item
				$i->save();

				// Increment the count
				++$count;
			}
		}

		if (count($data) == $count)
		{
			return true;
		}

		return false;
	}

}