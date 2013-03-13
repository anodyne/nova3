<?php namespace Nova\Core\Model\Character;

use Model;

class Positions extends Model {
	
	protected $table = 'character_positions';
	
	protected static $properties = array(
		'id', 'character_id', 'position_id', 'primary',
	);

}