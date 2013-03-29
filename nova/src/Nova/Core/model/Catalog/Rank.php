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

	protected $fillable = array(
		'name', 'location', 'preview', 'blank', 'extension', 'status',
		'credits', 'default', 'genre',
	);

	protected static $properties = array(
		'id', 'name', 'location', 'preview', 'blank', 'extension', 'status', 
		'credits', 'default', 'genre', 'created_at', 'updated_at',
	);

	/**
	 * Scope the query to active items.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeActive($query)
	{
		$query->where('status', Status::ACTIVE);
	}

	/**
	 * Scope the query to inactive items.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeInactive($query)
	{
		$query->where('status', Status::INACTIVE);
	}

	/**
	 * Scope the query to the current genre.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeCurrentGenre($query)
	{
		$query->where('genre', Config::get('nova.genre'));
	}

	/**
	 * Scope the query to the default item.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeDefault($query)
	{
		$query->where('default', (int) true);
	}
	
	/**
	 * Get the default rank catalog item.
	 *
	 * @param	bool	Only return the pertinent value?
	 * @return	Collection
	 * @throws	Exception
	 */
	public static function getDefault($valueOnly = false)
	{
		// Find the items
		$result = static::active()->default()->currentGenre()->first();
		
		if ($result)
		{
			if ($valueOnly)
			{
				return $result->location;
			}
			
			return $result;
		}

		throw new Exception(lang('error.exception.model.get.notFound'));
	}

	/**
	 * Install via QuickInstall.
	 *
	 * @param	string	A specific location to install
	 * @return	void
	 */
	public static function install($location = false)
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		if ( ! $location)
		{
			// Get all the rank set locations
			$ranks = static::active()->currentGenre()->get()->toSimpleArray('id', 'location');

			// Create a new finder and filter the results
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
					static::add($data);
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
				static::add($data);
			}
		}
	}

	/**
	 * Uninstall via QuickInstall.
	 *
	 * @param	string	A specific location to uninstall
	 * @return	void
	 */
	public static function uninstall($location = 'foo')
	{
		if ( ! $location)
		{
			// Get all the rank locations
			$ranks = static::get();

			// Loop through the ranks and remove them
			foreach ($ranks as $m)
			{
				$m->delete();
			}
		}
		else
		{
			// Remove the item from the database
			$item = static::remove(array('location' => $location));
		}
	}

}