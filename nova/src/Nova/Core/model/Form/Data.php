<?php
/**
 * Form Data Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Form;

class Data extends \Model {
	
	protected $table = 'form_data';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20),
		'field_id' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'character_id' => array(
			'type' => 'string',
			'constraint' => 11,
			'null' => true),
		'item_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'value' => array(
			'type' => 'text',
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	/**
	 * Get specific form data.
	 *
	 * @api
	 * @param	string	the type of data
	 * @param	int		the ID of the item
	 * @return	object
	 */
	public static function getData($type, $id)
	{
		switch ($type)
		{
			case 'field':
				$field_column = 'field_id';
			break;

			case 'character':
			case 'bio':
				$field_column = 'character_id';
			break;

			case 'user':
				$field_column = 'user_id';
			break;

			case 'item':
			case 'tour':
			case 'specs':
			case 'app':
			default:
				$field_column = 'item_id';
			break;
		}
		
		return static::query()->where($field_column, $id)->get();
	}
	
	/**
	 * Create data for a single field in the data table.
	 *
	 * @api
	 * @param	array 	the data array to use for creation
	 * @return	object
	 */
	public static function createData(array $data)
	{
		$record = \Model_Form_Data::forge();
		
		foreach ($data as $key => $value)
		{
			$record->{$key} = \Security::xss_clean($value);
		}
		
		$record->save();
		
		return $record;
	}
	
	/**
	 * Update data in the data table.
	 *
	 * @api
	 * @param	string	the form to update
	 * @param	int		the ID to udpate
	 * @param	array 	a data array of information to update
	 * @return	bool
	 */
	public static function updateData($type, $id, array $data)
	{
		$results = array();
		
		// figure out what field we need to use
		switch ($type)
		{
			case 'bio':
				$field = 'character_id';
			break;
			
			case 'user':
				$field = 'user_id';
			break;
			
			default:
				$field = 'item_id';
			break;
		}
		
		// loop through the data array and make the changes
		foreach ($data as $key => $value)
		{
			// get the record
			$record = static::query()->where('field_id', $key)->where($field, $id)->get_one();
			
			// update the values
			$record->value = \Security::xss_clean($value);
			$retval = $record->save();
			
			$results[] = ($retval !== false) ? true : $retval;
		}
		
		if (in_array(false, $results))
		{
			return false;
		}
		
		return true;
	}
}
