<?php namespace Nova\Core\Models\Entities\User;

use Model;
use RankCatalog;

class Preferences extends Model {
	
	public $timestamps = false;
	
	protected $table = 'user_preferences';

	protected $fillable = array(
		'user_id', 'key', 'value',
	);
	
	protected static $properties = array(
		'id', 'user_id', 'key', 'value',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Belongs To: User
	 *
	 * @return	User
	 */
	public function user()
	{
		return $this->belongsTo('User', 'user_id');
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
	public function scopeKey($query, $key)
	{
		$query->where('key', $key);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/
	
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