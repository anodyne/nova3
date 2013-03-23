<?php namespace Nova\Core\Model\Rank;

use Model;
use Config;
use Status;
use Rank;

class Group extends Model {
	
	protected $table = 'ranks_groups_';
	
	protected static $properties = array(
		'id', 'name', 'order', 'status', 'created_at', 'updated_at',
	);

	/**
	 * Has Many: Ranks
	 */
	public function ranks()
	{
		return $this->hasMany('Rank');
	}

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Rank_Group' => array(
			'events' => array('before_delete', 'after_insert', 'after_update')
		),
	);

	/**
	 * Since the table name is appended with the genre, we can't hard-code
	 * it in to the model. When the object is created, we have to pull the
	 * genre out of the config and name the table.
	 *
	 * @internal
	 * @return	void
	 */
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);

		// Set the name of the table
		$this->setTable('ranks_groups_'.Config::get('nova.genre'));
	}

	/**
	 * Returns all items from the database.
	 *
	 * @param	int|bool	The status to pull back
	 * @return	Collection
	 */
	public static function getItems($status = false)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		// Add a where statement only if we want just displayed items
		if ($status !== false)
		{
			$query->where('status', $status);
		}

		return $query->orderBy('order', 'asc')->get();
	}
	
}