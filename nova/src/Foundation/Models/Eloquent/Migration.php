<?php namespace Nova\Core\Models\Eloquent;

use Model;

class Migration extends Model {

	protected $table = 'migrations';
	
	protected static $properties = array(
		'migration', 'batch',
	);

	/**
	 * Because the migration table doesn't have a primary key, we can't use
	 * the query builder and need to do this with raw SQL.
	 *
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