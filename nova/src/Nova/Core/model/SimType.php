<?php namespace Nova\Core\Model;

use Model;

class SimType extends Model {

	public $timestamps = false;

	protected $table = 'sim_types';

	protected $fillable = array(
		'name',
	);
	
	protected static $properties = array(
		'id', 'name',
	);

}