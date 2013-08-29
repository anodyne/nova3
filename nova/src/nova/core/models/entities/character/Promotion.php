<?php namespace nova\core\models\entities\character;

use Model;

class Promotion extends Model {
	
	protected $table = 'character_promotions';

	protected $fillable = array(
		'character_id', 'old_order', 'old_rank', 'new_order', 'new_rank',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'character_id', 'old_order', 'old_rank', 'new_order', 'new_rank',
		'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Character
	 */
	public function character()
	{
		return $this->belongsTo('Character');
	}

}