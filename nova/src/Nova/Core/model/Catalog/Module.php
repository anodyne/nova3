<?php namespace Nova\Core\Model\Catalog;

use File;
use Model;
use Config;
use Status;
use Artisan;
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
			// Get all the module locations
			$modules = static::active()->get()->toSimpleArray('id', 'location');

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
	 * Uninstall all the items.
	 *
	 * @return	void
	 */
	public static function uninstallAll()
	{
		// Get all the active items
		$items = static::active()->get();

		// Loop through the items and uninstall them
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
		// Assign our path to a variable
		$dir = APPPATH."module/".$this->location;

		// Reset the migrations if they exist
		if (File::isDirectory($dir."/database/migrations"))
		{
			Artisan::call('migrate:reset', array('--path' => $dir."/database/migrations"));
		}

		// Delete this from the database
		$this->delete();
	}

}