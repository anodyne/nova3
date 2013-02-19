<?php
/**
 * Rank Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Model;
use RankInfoModel;
use CharacterModel;
use RankGroupModel;

class Rank extends Model {

	protected $table = 'ranks_';
	
	protected static $properties = array(
		'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'info_id' => array('type' => 'int', 'constraint' => 11, 'null' => true),
		'group_id' => array('type' => 'int', 'constraint' => 11),
		'base' => array('type' => 'string', 'constraint' => 50, 'null' => true),
		'pip' => array('type' => 'string', 'constraint' => 50, 'null' => true),
	);

	/**
	 * Belongs To: Rank Info
	 */
	public function info()
	{
		return $this->belongsTo('RankInfoModel');
	}

	/**
	 * Belongs To: Rank Group
	 */
	public function group()
	{
		return $this->belongsTo('RankGroupModel');
	}

	/**
	 * Has Many: Characters
	 */
	public function characters()
	{
		return $this->hasMany('CharacterModel');
	}

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Rank' => array(
			'events' => array('before_delete', 'after_insert', 'after_update', 'before_save')
		),
	);

	/**
	 * Since the table name is appended with the genre, we can't hard-code
	 * it in to the model. The _init method is necessary since PHP won't
	 * allow creating an object project that's dynamic. This method changes
	 * the name of the table once the class is loaded.
	 *
	 * @internal
	 * @return	void
	 */
	public static function _init()
	{
		static::$_table_name = static::$_table_name.\Config::get('nova.genre');
	}
}
