<?php namespace nova\core\models\entities\character;

use Model;

class Positions extends Model {
	
	protected $table = 'character_positions';

	protected $fillable = array(
		'character_id', 'position_id', 'primary',
	);
	
	protected static $properties = array(
		'id', 'character_id', 'position_id', 'primary',
	);

}