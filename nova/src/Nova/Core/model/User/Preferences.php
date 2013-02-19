<?php
/**
 * User Preferences Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model\User;

use Model;
use UserModel;

class Preferences extends Model {
	
	protected $table = 'user_preferences';
	
	protected static $properties = array(
		'id'		=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'user_id'	=> array('type' => 'int', 'constraint' => 11, 'default' => 0),
		'key'		=> array('type' => 'string', 'constraint' => 50),
		'value'		=> array('type' => 'text', 'null' => true),
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
	 * @return	object
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
			
			'rank'					=> \Model_Catalog_Rank::getDefault(true),
			'skin_main'				=> \Model_Catalog_SkinSec::getDefault('main', true),
			'skin_admin'			=> \Model_Catalog_SkinSec::getDefault('admin', true),
			
			# TODO: need to pull these values from the menu
			'my_links'				=> '',
			
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
			$record = static::forge();

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
		// Load the items
		$items = static::query()->where('user_id', $id)->get();

		// Set the count to 0
		$count = 0;

		foreach ($items as $i)
		{
			// If we've got the item in the array, update it
			if (array_key_exists($i->key, $data))
			{
				// Update the value
				$i->value = \Security::xss_clean($data[$i->key]);

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
