<?php
/**
 * Form Values Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Form;

class Value extends \Model {
	
	protected $table = 'form_values';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'field_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'value' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'field' => array(
			'model_to' => '\\Model_Form_Field',
			'key_to' => 'id',
			'key_from' => 'field_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Get values.
	 *
	 * @api
	 * @param	int		the field ID
	 * @return	object
	 */
	public static function getItems($field)
	{
		return static::query()->where('field_id', $field)->order_by('order', 'asc')->get();
	}
}
