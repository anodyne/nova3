<?php
/**
 * Form Fields Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Form;

class Field extends \Model {
	
	protected $table = 'form_fields';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20),
		'section_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'text'),
		'label' => array(
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
		'restriction' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'help' => array(
			'type' => 'text',
			'null' => true),
		'selected' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'value' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'html_name' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'html_id' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'html_class' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => 'span4'),
		'html_rows' => array(
			'type' => 'int',
			'constraint' => 3,
			'default' => 5),
		'placeholder' => array(
			'type' => 'text',
			'null' => true),
		'updated_at' => array(
			'type' => 'datetime',
			'null' => true),
	);
	
	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'section' => array(
			'model_to' => '\\Model_Form_Section',
			'key_to' => 'id',
			'key_from' => 'section_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'values' => array(
			'model_to' => '\\Model_Form_Value',
			'key_to' => 'field_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Form_Field' => array(
			'events' => array('before_delete', 'after_insert', 'after_update')
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	/**
	 * Get fields.
	 *
	 * @api
	 * @param	string	the form key
	 * @param	int		the section ID
	 * @param	bool	only active items
	 * @return	object
	 */
	public static function getItems($key, $section = null, $active = true)
	{
		$items = static::query();
		$items->where('form_key', $key);

		if ($section !== null)
		{
			$items->where('section_id', $section);
		}

		if ($active)
		{
			$items->where('status', \Status::ACTIVE);
		}

		$items->order_by('order', 'asc');

		return $items->get();
	}

	/**
	 * Get any values for the current field. This is only used for
	 * select menus.
	 *
	 * @api
	 * @return	array
	 */
	public function getValues()
	{
		// get the values
		$values = \Model_Form_Value::getItems($this->id);

		// start with an empty array
		$items = array();

		// make sure we have values for this field
		if (count($values) > 0)
		{
			// loop through the values and put them in the right format
			foreach ($values as $val)
			{
				$items[$val->value] = $val->content;
			}
		}

		return $items;
	}
}
