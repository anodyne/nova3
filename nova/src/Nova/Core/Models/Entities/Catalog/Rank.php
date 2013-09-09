<?php namespace Nova\Core\Models\Entities\Catalog;

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
		'credits', 'genre',
	);

	protected $dates = array('created_at', 'updated_at');

	protected static $properties = array(
		'id', 'name', 'location', 'preview', 'blank', 'extension', 'status', 
		'credits', 'genre', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

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
	 * Scope the query to a skin by location.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeLocation($query, $location)
	{
		$query->where('location', $location);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$a = Config::get('app.aliases');

		// Setup the listeners
		static::setupEventListeners($a['RankCatalog'], $a['RankCatalogEventHandler']);
	}

	/*
	|--------------------------------------------------------------------------
	| QuickInstall Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Install via QuickInstall.
	 *
	 * @param	string	A specific location to install
	 * @return	void
	 */
	public static function install($location = false)
	{
		if ( ! $location)
		{
			// Get all the rank set locations
			$ranks = static::active()->currentGenre()->get()->toSimpleArray('id', 'location');

			// Create a new finder and filter the results
			$finder = Finder::create()->directories()->in(static::getPath())
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
				$file = static::getPath().$f->getRelativePathName()."/rank.json";

				// Make sure the file exists first
				if (File::exists($file))
				{
					// Get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content, true);

					// Create the item
					static::create($data);
				}
			}
		}
		else
		{
			// Assign our path to a variable
			$file = static::getPath()."{$location}/rank.json";
			
			// Make sure the file exists first
			if (File::exists($file))
			{
				// Get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content, true);
				
				// Create the item
				static::create($data);
			}
		}
	}

	/**
	 * Uninstall via QuickInstall.
	 *
	 * @return	void
	 */
	public static function uninstallAll()
	{
		// Get all the rank locations
		$items = static::active()->get();

		// Loop through the ranks and remove them
		foreach ($items as $i)
		{
			$i->uninstall();
		}
	}

	/**
	 * Uninstall the item.
	 *
	 * @return	void
	 */
	public function uninstall()
	{
		// Delete this from the database
		$this->delete();
	}

	/**
	 * Get the QuickInstall file.
	 *
	 * @param	string	File name
	 * @return	stdClass|bool
	 */
	public function getQuickInstallFile($file = 'rank.json')
	{
		// Set the filename
		$filename = static::getPath()."{$this->location}/{$file}";
		
		if (File::exists($filename))
		{
			// Get the contents of the QuickInstall file
			$contents = File::get($filename);

			return json_decode($contents);
		}

		return false;
	}

	/**
	 * Get the path to where this resource is located.
	 *
	 * @return	string
	 */
	public static function getPath()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		return APPPATH."assets/common/{$genre}/ranks/";
	}

}