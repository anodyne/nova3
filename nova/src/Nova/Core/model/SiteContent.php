<?php
/**
 * Site Content Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Cache;
use Model;
use SettingsModel;

class SiteContent extends Model {

	protected $table = 'site_contents';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 255),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'title','header','message','other'",
			'default' => 'message'),
		'section' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'page' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'protected' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);
	
	/**
	 * Get a specific piece of content from the database.
	 *
	 * @api
	 * @param	string	the key of the content to get
	 * @param	boolean	whether to pull only the value or the full object
	 * @return	mixed
	 */
	public static function getContentItem($key, $valueOnly = true)
	{
		// Get the content
		$result = static::getItem($key, 'key', false);

		if ($valueOnly === true)
		{
			return $result->content;
		}
		
		return $result;
	}
	
	/**
	 * Get all of the content for a section from the database.
	 *
	 * @api
	 * @param	string	the type of message to pull
	 * @param	string	the section to pull for
	 * @return	array
	 */
	public static function getSectionContent($type, $section)
	{
		// Try to get the cache first
		$cache = Cache::get("content_{$type}_{$section}");

		// If we have something in the cache, return it instead of querying
		if ($cache !== null)
		{
			return $cache;
		}

		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		// Query the database
		$result = $query->where('type', $type)->where('section', $section)->get();
			
		if (count($result) > 0)
		{
			foreach ($result as $row)
			{
				// Set the content as a variable so we can change it
				$content = $row->content;
				
				// Find the pattern {{table: key}} in the content
				preg_match_all('/{{([a-zA-Z]+): ([a-zA-Z_-]+)}}/', $content, $arr, PREG_PATTERN_ORDER);
				
				// Make sure there were matches
				if (count($arr[0]) > 0)
				{
					// Loop through the matches and make the changes
					foreach ($arr[2] as $k => $v)
					{
						// Get the item from the settings table
						$replace = SettingsModel::getItems($v);
						
						// Set the new content
						$content = str_replace($arr[0][$k], $replace, $content);
					}
				}
				
				// Set the items with the content
				$values[$row->page] = $content;
			}
			
			// Cache the information
			Cache::forever("content_{$type}_{$section}", $values);
			
			return $values;
		}

		return array();
	}
	
	/**
	 * Update site content.
	 *
	 * You can also pass a larger array with multiple values to the method to
	 * update multiple settings at the same time. The data array just needs to
	 * stay in the (setting key) => (setting value) format.
	 *
	 * @api
	 * @param	array 	The data array for updating the site content
	 * @return	void
	 */
	public static function updateSiteContent(array $data)
	{
		foreach ($data as $key => $value)
		{
			$record = static::query()->where('key', $key)->get_one();
			
			// Track what we need to clear and re-cache
			$clear[$record->section][] = $record->type;
			
			$record->content = $value;
			$record->save();
		}
		
		foreach ($clear as $section => $type)
		{
			foreach ($type as $t)
			{
				// Delete the cached item
				Cache::forget("content_{$t}_{$section}");
				
				// Now grab that content again (which will automatically re-cache everything)
				static::getSectionContent($t, $section);
			}
		}
	}
	
	private static function _substitute($content)
	{
		preg_match_all('/{{([a-zA-Z]+): ([a-zA-Z_-]+)}}/', $content, $arr, PREG_PATTERN_ORDER);
	}
}
