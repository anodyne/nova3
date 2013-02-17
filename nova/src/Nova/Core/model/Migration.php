<?php
/**
 * Migration Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Migration extends \Model
{
	protected $table = 'migration';
	
	protected static $_properties = array(
		'name' => array(
			'type' => 'string',
			'constraint' => 50),
		'type' => array(
			'type' => 'string',
			'constraint' => 25),
		'version' => array(
			'type' => 'int',
			'constraint' => 11),
	);

	/**
	 * Because the migration table doesn't have a primary key, we can't use
	 * the query builder and need to do this with raw SQL.
	 *
	 * @api
	 * @param	string	the name of the migration
	 * @return	int
	 */
	public static function getVersion($item)
	{
		$item = \DB::query("SELECT * FROM ".\DB::table_prefix()."migration WHERE name = '$item'")
			->as_object()
			->execute()
			->current();

		return $item->version;
	}
}
