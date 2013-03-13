<?php namespace Nova\Core\Model\Catalog;

use File;
use Model;
use Config;
use Status;
use Exception;
use SplFileInfo;
use QuickInstallInterface;
use Symfony\Component\Finder\Finder;

class Rank extends Model implements QuickInstallInterface {

	protected $table = 'catalog_ranks';

	protected static $properties = array(
		'id', 'name', 'location', 'preview', 'blank', 'extension', 'status', 
		'credits', 'default', 'genre', 'created_at', 'updated_at',
	);
	
	/**
	 * Get all items from the catalog.
	 *
	 * @param	string	Status to pull
	 * @param	bool	Whether to limit to the current genre (true) or all genres (false)
	 * @param	string	The property to return
	 * @return	Collection
	 */
	public static function getItems($status = Status::ACTIVE, $limitToCurrentGenre = true, $onlyReturn = false)
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

		if ($onlyReturn !== false)
		{
			// Temporary holding array
			$retval = array();

			// Loop through the results
			foreach ($query->get() as $row)
			{
				$retval[] = $row->{$onlyReturn};
			}

			return $retval;
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
			// Get all the rank set locations
			$ranks = static::getItems(Status::ACTIVE, true, 'location');

			// Create a new finder
			$finder = Finder::create()->directories()->in(APPPATH."assets/common/{$genre}/ranks")
				->filter(function(SplFileInfo $fileinfo) use ($ranks)
				{
					if (in_array($fileinfo->getRelativePathName(), $ranks))
					{
						return false;
					}
				});

			// Loop through the directories and install
			foreach ($finder as $f)
			{
				// Assign our path to a variable
				$file = APPPATH."assets/common/{$genre}/ranks/".$f->getRelativePathName()."/rank.json";

				// Make sure the file exists first
				if (File::exists($file))
				{
					// Get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content, true);

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
			if (File::exists($file))
			{
				// Get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content, true);
				
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