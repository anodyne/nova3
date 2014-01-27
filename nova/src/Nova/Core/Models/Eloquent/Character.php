<?php namespace Nova\Core\Models\Eloquent;

use Html;
use Event;
use Model;
use Config;
use Status;
use DynamicForm;
use FormDataModel;
use MediaInterface;
use FormDataInterface;

class Character extends Model implements MediaInterface, FormDataInterface {

	protected $table = 'characters';

	protected $fillable = array(
		'first_name', 'last_name', 'middle_name', 'suffix', 'status',
		'user_id', 'rank_id', 'activated_at', 'deactivated_at', 'last_post',
	);

	protected $dates = array(
		'created_at', 'updated_at', 'activated_at', 'deactivated_at', 'last_post',
	);
	
	protected static $properties = array(
		'id', 'user_id', 'status', 'first_name', 'middle_name', 'last_name', 
		'suffix', 'rank_id', 'activated_at', 'deactivated_at', 'last_post', 
		'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Belongs To: Rank
	 */
	public function rank()
	{
		return $this->belongsTo('RankModel', 'rank_id');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('UserModel', 'user_id');
	}

	/**
	 * Has One: Application
	 */
	public function app()
	{
		return $this->hasOne('ApplicationModel');
	}

	/**
	 * Has Many: Personal Logs
	 */
	public function logs()
	{
		return $this->hasMany('PersonalLogModel');
	}

	/**
	 * Has Many: Announcements
	 */
	public function announcements()
	{
		return $this->hasMany('AnnouncementModel');
	}

	/**
	 * Has Many: Promotion Records
	 */
	public function promotions()
	{
		return $this->hasMany('CharacterPromotionModel');
	}

	/**
	 * Has Many: Awards
	 */
	public function awards()
	{
		return $this->hasMany('AwardRecipientModel');
	}

	/**
	 * Belongs To Many: Posts (through Post Authors)
	 */
	public function posts()
	{
		return $this->belongsToMany('PostModel', 'post_authors');
	}

	/**
	 * Belongs To Many: Positions (through Character Positions)
	 */
	public function positions()
	{
		return $this->belongsToMany('PositionModel', 'character_positions')
			->withPivot('primary');
	}

	/**
	 * Polymorphic Relationship: Media
	 */
	public function images()
	{
		return $this->morphMany('Media', 'imageable');
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

	/**
	 * Scope the query to non-played characters.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeNpc($query)
	{
		$query->where('status', Status::ACTIVE)->where('user_id', 0);
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
		//static::setupEventListeners($a['CharacterModel'], $a['CharacterModelEventHandler']);
	}

	/**
	 * Get the dynamic form for the character.
	 *
	 * @param	bool	$editable	Do we want the editable version of the form?
	 * @return	string
	 */
	public function getDynamicForm($editable = false)
	{
		return DynamicForm::setup('character', $this->id, $editable)->build();
	}

	/**
	 * Get the name of the character.
	 *
	 * @param	bool	Show a link to the character bio?
	 * @return	string
	 */
	public function getName($link = false)
	{
		return $this->constructName(array($this->first_name, $this->last_name), $link);
	}

	/**
	 * Get the name and full rank of the character.
	 *
	 * @param	bool	Show a link to the character bio?
	 * @return	string
	 */
	public function getNameWithRank($link = false)
	{
		return $this->constructName(array($this->rank->info->name, $this->getName(false)), $link);
	}

	/**
	 * Get the name and short rank of the character.
	 *
	 * @param	bool	Show a link to the character bio?
	 * @return	string
	 */
	public function getNameWithShortRank($link = false)
	{
		return $this->constructName(array($this->rank->info->short_name, $this->getName(false)), $link);
	}

	/**
	 * Put the name together the way it should be.
	 *
	 * @param	array	The pieces of the name
	 * @param	bool	Show a link to the character bio?
	 * @return	string
	 */
	protected function constructName(array $pieces, $link = false)
	{
		foreach ($pieces as $key => $value)
		{
			if (empty($value))
			{
				unset($pieces[$key]);
			}
		}

		if ($link)
		{
			return HTML::link("personnel/character/{$this->id}", implode(' ', $pieces));
		}

		return implode(' ', $pieces);
	}

	/**
	 * Does the character have a user associated with it?
	 *
	 * @return	bool
	 */
	public function hasUser()
	{
		return ($this->user() !== null and $this->user->id > 0);
	}
	
	/**
	 * Update the position record.
	 *
	 * @param	int		New ID to use
	 * @param	int		Old ID to use (for finding the record)
	 * @return	void
	 */
	public function updatePosition($newId, $oldId = false)
	{
		// Build the arguments
		$args['character_id'] = $this->id;

		if ($oldId)
		{
			$args['position_id'] = $oldId;
		}

		// Get the position record
		$position = CharacterPositionModel::getItems($args);

		// Update to the new position
		$position->position_id = $newId;
		$position->save();
	}

	/**
	 * Can this character be deleted?
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

		return true;
	}

	/**
	 * Delete a character.
	 *
	 * @return	bool
	 */
	public function deleteCharacter()
	{
		if ($this->canBeDeleted())
		{
			// Delete the user
			$this->delete();

			return true;
		}
		else
		{
			// The character can't be deleted, so we'll just hide them
			$this->status = Status::REMOVED;
			$this->save();

			return true;
		}
	}

	/*
	|--------------------------------------------------------------------------
	| MediaInterface Implementation
	|--------------------------------------------------------------------------
	*/

	public function addMedia($file, $options)
	{
		// Move the file to the right location
		$file->move(APPPATH.'assets/images/characters');
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
		$characters = $query->get();

		if ($characters->count() > 0)
		{
			foreach ($characters as $c)
			{
				FormDataModel::create(array_merge($data, ['data_id' => $c->id]));
			}
		}
	}

}