<?php namespace Nova\Core\Model\Character;

use Model;
use CharacterModel;

class Promotion extends Model {
	
	protected $table = 'character_promotions';
	
	protected static $properties = array(
		'id', 'character_id', 'old_order', 'old_rank', 'new_order', 'new_rank',
		'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Character
	 */
	public function character()
	{
		return $this->belongsTo('CharacterModel');
	}

}