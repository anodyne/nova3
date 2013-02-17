<?php
/**
 * Skin Section Catalog Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Catalog;

class SkinSection extends \Model {
	
	protected $table = 'catalog_skinsecs';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'section' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'skin' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'preview' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'nav' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => 'dropdown'),
	);
	
	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'skins' => array(
			'model_to' => '\\Model_Catalog_Skin',
			'key_to' => 'location',
			'key_from' => 'skin',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get the default skin section catalog item.
	 *
	 * @api
	 * @param	string	the section to pull
	 * @return	object
	 */
	public static function getDefault($section, $valueOnly = false)
	{
		$result = static::query()
			->where(array('default', (int) true))
			->where(array('section', $section))
			->get_one();
		
		if ($valueOnly)
		{
			return $result->skin;
		}
		
		return $result;
	}

	/**
	 * Get all items from the catalog.
	 *
	 * @api
	 * @param	array	The arguments
	 * @param	string	The status
	 * @return	object
	 */
	public static function getItems(array $arguments, $returnOne = false)
	{
		// Start the query
		$result = static::query();

		foreach ($arguments as $col => $val)
		{
			$result->where($col, $val);
		}

		if ($returnOne)
		{
			return $result->get_one();
		}

		return $result->get();
	}
}
