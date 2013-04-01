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
	 * Uninstall via QuickInstall.
	 *
	 * @param	string	A specific location to uninstall
	 * @return	void
	 */
	public static function uninstall($location = false)
	{
		if ( ! $location)
		{
			// Get all the module locations
			$modules = static::get()->toSimpleArray('id', 'location');

			// Create a new finder and filter the results
			$finder = Finder::create()->directories()->in(APPPATH."module");

			// Loop through the directories and uninstall
			foreach ($finder as $f)
			{
				// Assign our path to a variable
				$dir = APPPATH."module/".$f->getRelativePathName();

				// Run the migrations if they exist
				if (File::isDirectory($dir."/database/migrations"))
				{
					Artisan::call('migrate:rollback', array('--path' => $dir."/database/migrations"));
				}
			}

			// Loop through the modules and remove them
			foreach ($modules as $m)
			{
				$m->delete();
			}
		}
		else
		{
			// Assign our path to a variable
			$dir = APPPATH."module/".$location;

			// Rollback the migrations if they exist
			if (File::isDirectory($dir."/database/migrations"))
			{
				Artisan::call('migrate:rollback', array('--path' => $dir."/database/migrations"));
			}

			// Remove the item from the database
			$item = static::remove(array('location' => $location));
		}
	}

}