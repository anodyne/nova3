<?php
/**
 * Rank Catalog Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model\Catalog;

use Model;
use Config;
use Status;
use Exception;
use QuickInstallInterface;
use FuelPHP\FileSystem\Directory;

class Rank extends Model implements QuickInstallInterface {

	protected $table = 'catalog_ranks';

	protected static $properties = array(
		'id'			=> array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'name'			=> array('type' => 'string'),
		'location'		=> array('type' => 'string'),
		'preview'		=> array('type' => 'string', 'constraint' => 50, 'default' => 'preview.png'),
		'blank'			=> array('type' => 'string', 'constraint' => 50, 'default' => 'blank.png'),
		'extension'		=> array('type' => 'string', 'constraint' => 5, 'default' => '.png'),
		'status'		=> array('type' => 'tinyint', 'constraint' => 4, 'default' => Status::ACTIVE),
		'credits'		=> array('type' => 'text', 'null' => true),
		'default'		=> array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
		'genre'			=> array('type' => 'string', 'constraint' => 10),
		'created_at'	=> array('type' => 'datetime'),
		'updated_at'	=> array('type' => 'datetime'),
	);
	
	/**
	 * Get all items from the catalog.
	 *
	 * @param	string	Status to pull
	 * @param	bool	Whether to limit to the current genre (true) or all genres (false)
	 * @return	Collection
	 */
	public static function getItems($status = Status::ACTIVE, $limitToCurrentGenre = true)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		if ($limitToCurrentGenre)
		{
			$query->where('genre', Config::get('nova.genre'));
		}

		if ( ! empty($status))
		{
			$query->where('status', $status);
		}
		
		return $query->get();
	}
	
	/**
	 * Get the default rank catalog item.
	 *
	 * @param	bool	Return just the location value (true) or the whole object (false)
	 * @return	string|Collection
	 */
	public static function getDefault($valueOnly = false)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		$result = $query->where('default', (int) true)->first();
		
		if ($valueOnly)
		{
			return $result->location;
		}
		
		return $result;
	}

	/**
	 * Install via QuickInstall.
	 *
	 * @param	string	A specific location to install
	 * @return	void
	 */
	public static function install($location = null)
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		if ($location === null)
		{
			// Map the ranks directory
			$fs = new Directory(APPPATH."assets/common/{$genre}/ranks");
			$dir = $fs->listFiles();

			// Get all the rank set locations
			$ranks = static::getItems();

			if (count($ranks) > 0)
			{
				// Start by removing anything that's already installed
				foreach ($ranks as $rank)
				{
					if (array_key_exists($rank->location.DIRECTORY_SEPARATOR, $dir))
					{
						unset($dir[$rank->location.DIRECTORY_SEPARATOR]);
					}
				}
			}
				
			// Loop through the directories now
			foreach ($dir as $key => $value)
			{
				// Assign our path to a variable
				$file = APPPATH."assets/common/{$genre}/ranks/{$key}rank.json";

				// Make sure the file exists first
				if (file_exists($file))
				{
					// Get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);

					// Create the item
					static::createItem($data);
				}
			}
		}
		else
		{
			// Assign our path to a variable
			$file = APPPATH."assets/common/{$genre}/ranks/{$location}/rank.json";
			
			// Make sure the file exists first
			if (file_exists($file))
			{
				// Get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				// Create the item
				static::createItem($data);
			}
		}
	}

	/**
	 * Uninstall via QuickInstall.
	 *
	 * @param	string	A specific location to uninstall
	 * @return	void
	 * @throws	Exception
	 */
	public static function uninstall($location)
	{
		throw new Exception('Uninstall method is not implemented.');
	}

}