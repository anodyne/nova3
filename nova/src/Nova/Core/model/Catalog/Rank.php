<?php
/**
 * Rank Catalog Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Catalog;

class Rank extends \Model implements \QuickInstallInterface {

	protected $table = 'catalog_ranks';

	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'preview' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'preview.png'),
		'blank' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'blank.png'),
		'extension' => array(
			'type' => 'string',
			'constraint' => 5,
			'default' => '.png'),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'credits' => array(
			'type' => 'text'),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'genre' => array(
			'type' => 'string',
			'constraint' => 10,
			'null' => true),
	);
	
	/**
	 * Get all items from the catalog.
	 *
	 * @api
	 * @param	string	Status to pull
	 * @param	bool	Whether to limit to the current genre (true) or all genres (false)
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE, $limitToGenre = true)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		if ($limitToGenre)
		{
			$query->where('genre', \Config::get('nova.genre'));
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
	 * @api
	 * @param	bool	Return just the location value (true) or the whole object (false)
	 * @return	string|object
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

	public static function install($location = null)
	{
		if ($location === null)
		{
			// get the directory listing for the genre
			$dir = \File::read_dir(APPPATH.'assets/common/'.\Config::get('nova.genre').'/ranks/');

			// get all the rank sets locations
			$ranks = static::getItems();

			if (count($ranks) > 0)
			{
				// start by removing anything that's already installed
				foreach ($ranks as $rank)
				{
					if (array_key_exists($rank->location.DS, $dir))
					{
						unset($dir[$rank->location.DS]);
					}
				}
			}
				
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				// assign our path to a variable
				$file = APPPATH.'assets/common/'.\Config::get('nova.genre').'/ranks/'.$key.'rank.json';

				// make sure the file exists first
				if (file_exists($file))
				{
					// get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);

					// create the item
					static::createItem($data);
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'assets/common/'.\Config::get('nova.genre').'/ranks/'.$location.'/rank.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				// create the item
				static::createItem($data);
			}
		}
	}

	public static function uninstall($location)
	{
		throw new \Exception('Uninstall method is not implemented.');
	}
}
