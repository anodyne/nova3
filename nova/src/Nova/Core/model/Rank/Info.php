<?php namespace Nova\Core\Model\Rank;

use Event;
use Model;
use Config;
use Status;

class Info extends Model {
	
	protected $table = 'ranks_info_';

	protected $fillable = array(
		'name', 'short_name', 'order', 'group', 'status',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'name', 'short_name', 'order', 'group', 'status', 'created_at', 'updated_at',
	);

	/**
	 * Has Many: Ranks
	 */
	public function ranks()
	{
		return $this->hasMany('Rank');
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

		Event::listen("eloquent.created: {$classes['RankInfo']}", "{$classes['RankInfoHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['RankInfo']}", "{$classes['RankInfoHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['RankInfo']}", "{$classes['RankInfoHandler']}@beforeDelete");
	}

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
		$this->setTable('ranks_info_'.Config::get('nova.genre'));
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

		// add a where statement only if we want just displayed items
		if ($status !== false)
		{
			$query->where('status', $status);
		}

		return $query->orderBy('group', 'asc')->orderBy('order', 'asc')->get();
	}

}