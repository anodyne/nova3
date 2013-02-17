<?php
/**
 * Settings Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;
 
class Settings extends \Model {

	protected $table = 'settings';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 100),
		'value' => array(
			'type' => 'text',
			'null' => true),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'help' => array(
			'type' => 'text',
			'null' => true),
		'user_created' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	/**
	 * Get a specific set of settings from the database.
	 *
	 * @api
	 * @param	mixed 	a string with one key or an array of keys to use
	 * @param	boolean	whether to pull the value only (applies to single key requests)
	 * @return	mixed
	 */
	public static function getItems($keys, $valueOnly = true)
	{
		if (is_array($keys))
		{
			$obj = new \stdClass;
			
			$settings = static::all();
			
			foreach ($settings as $s)
			{
				if (in_array($s->key, $keys))
				{
					$obj->{$s->key} = $s->value;
				}
			}
			
			return $obj;
		}
		else
		{
			if ($keys === false or $keys === null)
			{
				$obj = new \stdClass;
				
				$settings = static::all();


				
				foreach ($settings as $s)
				{
					$attr = $s->getAttributes();
					
					$obj->{$attr['key']} = $s->value;
				}
				
				return $obj;
			}
			else
			{
				// Get a new instance of the model
				$instance = new static;

				// Start a new Query Builder
				$query = $instance->newQuery();

				$result = $query->where('key', $keys)->first();
				
				if ($valueOnly === true)
				{
					return $result->value;
				}
				
				return $result;
			}
		}
	}
	
	/**
	 * Update system settings.
	 *
	 * You can also pass a larger array with multiple values to the method to
	 * update multiple settings at the same time. The data array just needs to
	 * stay in the (setting key) => (setting value) format.
	 *
	 * @api
	 * @param	array 	the data array for updating the settings
	 * @return	void
	 */
	public static function updateItems(array $data)
	{
		foreach ($data as $key => $value)
		{
			$record = static::query()->where('key', $key)->get_one();

			if ($record)
			{
				$record->value = $value;
				$record->save();
			}
		}
	}
}
