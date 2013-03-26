<?php namespace Nova\Core\Model\Catalog;

use File;
use Model;
use Config;
use Status;
use Artisan;
use Exception;
use SplFileInfo;
use QuickInstallInterface;
use Symfony\Component\Finder\Finder;

class Module extends Model implements QuickInstallInterface {
	
	protected $table = 'catalog_modules';

	protected $fillable = array(
		'name', 'short_name', 'location', 'desc', 'status', 'credits',
	);
	
	protected static $properties = array(
		'id', 'name', 'short_name', 'location', 'desc', 'protected', 'status', 
		'credits', 'created_at', 'updated_at',
	);
	
	/**
	 * Get all the modules from the catalog.
	 *
	 * @param	string	Status to pull
	 * @param	string	The property to return
	 * @return	Collection
	 */
	public static function getItems($status = Status::ACTIVE, $onlyReturn = false)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		// Get on the status we want
		$query->where('status', $status);

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
	 * Install via QuickInstall.
	 *
	 * @param	string	A specific location to install
	 * @return	void
	 */
	public static function install($location = false)
	{
		if ( ! $location)
		{
			// Get all the module locations
			$modules = static::getItems(Status::ACTIVE, 'location');

			// Create a new finder and filter the results
			$finder = Finder::create()->directories()->in(APPPATH."module")
				->filter(function(SplFileInfo $fileinfo) use ($modules)
				{
					if (in_array($fileinfo->getRelativePathName(), $modules))
					{
						return false;
					}
				});

			// Loop through the directories and install
			foreach ($finder as $f)
			{
				// Assign our path to a variable
				$dir = APPPATH."module/".$f->getRelativePathName();

				// Run the migrations if they exist
				if (File::isDirectory($dir."/database/migrations"))
				{
					Artisan::call('migrate', array('--path' => $dir."/database/migrations"));
				}

				// Make sure the file exists first
				if (File::exists($dir."/module.json"))
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
			$dir = APPPATH."module/".$location;

			// Run the migrations if they exist
			if (File::isDirectory($dir."/database/migrations"))
			{
				Artisan::call('migrate', array('--path' => $dir."/database/migrations"));
			}

			// Make sure the file exists first
			if (File::exists($dir."/rank.json"))
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
	 * @throws	Exception
	 */
	public static function uninstall($location)
	{
		throw new Exception('Uninstall method is not implemented.');
	}

}