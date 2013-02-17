<?php
/**
 * Form Sections Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Form;

class Section extends \Model {
	
	protected $table = 'form_sections';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20),
		'tab_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'updated_at' => array(
			'type' => 'datetime',
			'null' => true),
	);

	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'tab' => array(
			'model_to' => '\\Model_Form_Tab',
			'key_to' => 'id',
			'key_from' => 'tab_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static $_has_many = array(
		'fields' => array(
			'model_to' => '\\Model_Form_Field',
			'key_to' => 'section_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Form_Section' => array(
			'events' => array('before_delete', 'after_insert', 'after_update')
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	/**
	 * Get sections.
	 *
	 * @api
	 * @param	string	the form
	 * @return	array
	 */
	public static function getItems($key)
	{
		$items = static::query()->where('form_key', $key)->order_by('name', 'asc')->get();

		$sections = array();

		if (count($items) > 0)
		{
			foreach ($items as $sec)
			{
				$sections[$sec->id] = $sec->name;
			}
		}

		return $sections;
	}
}
