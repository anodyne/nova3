<?php
/**
 * Character Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Status;
use LogModel;
use AppModel;
use UserModel;
use RankModel;
use PostModel;
use AnnouncementModel;
use CharacterPositionModel;
use CharacterPromotionModel;

class Character extends \Model
{
	protected $table = 'characters';
	
	protected static $properties = array(
		'id'			=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'user_id'		=> array('type' => 'int', 'constraint' => 11, 'default' => 0),
		'status'		=> array('type' => 'tinyint', 'constraint' => 1, 'default' => Status::PENDING),
		'first_name'	=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'middle_name'	=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'last_name'		=> array('type' => 'string', 'constraint' => 255, 'null' => true),
		'suffix'		=> array('type' => 'string', 'constraint' => 50, 'null' => true),
		'rank_id'		=> array('type' => 'int', 'constraint' => 11, 'default' => 1),
		'activated'		=> array('type' => 'datetime', 'null' => true),
		'deactivated'	=> array('type' => 'datetime', 'null' => true),
		'last_post'		=> array('type' => 'datetime', 'null' => true),
		'created_at'	=> array('type' => 'datetime', 'null' => true),
		'updated_at'	=> array('type' => 'datetime', 'null' => true),
	);
	
	/**
	 * Belongs To: Rank
	 */
	public function rank()
	{
		return $this->belongsTo('RankModel');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('UserModel');
	}

	/**
	 * Has One: Application
	 */
	public function app()
	{
		return $this->hasOne('AppModel');
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
	 * Has Many: Promotion Records
	 */
	public function promotions()
	{
		return $this->hasMany('CharacterPromotionModel');
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
		return $this->belongsToMany('PositionModel', 'character_positions');
	}

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Character' => array(
			'events' => array('after_insert')
		),
	);

	/**
	 * Get the name of the character.
	 *
	 * @param	bool	Show the character rank?
	 * @param	bool	Use the rank short name instead of the full name?
	 * @return	string
	 */
	public function getName($showRank = true, $showShortRank = false)
	{
		$pieces = array(
			($showRank) 
				? ($showShortRank) 
					? $this->rank->info->short_name 
					: $this->rank->info->name 
				: '',
			$this->first_name,
			$this->last_name
		);
		
		foreach ($pieces as $key => $p)
		{
			if (empty($p))
			{
				unset($pieces[$key]);
			}
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
	 * Get all characters from the database.
	 *
	 * @param	string	Status of characters to pull back
	 * @return	Collection
	 */
	public static function getCharacters($scope = 'active')
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		// Get everything
		$items = $query->get();

		// Filter the characters based on the scope
		$characters = $items->filter(function($item) use($scope)
		{
			switch ($scope)
			{
				case 'active':
				case 'inactive':
				case 'pending':
				default:
					return ($item->status == Status::toInt($scope));
				break;
				
				case 'npc':
					return ($item->status == Status::ACTIVE and $item->user_id === 0);
				break;
				
				case '':
					return ($item->status != Status::REMOVED);
				break;
			}
		});

		return $characters;
	}
}
