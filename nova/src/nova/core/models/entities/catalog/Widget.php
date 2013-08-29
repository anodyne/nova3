<?php namespace nova\core\models\entities\catalog;

use File;
use Model;
use Status;
use SplFileInfo;
use QuickInstallInterface;
use Symfony\Component\Finder\Finder;

class Widget extends Model implements QuickInstallInterface {
	
	protected $table = 'catalog_widgets';

	protected $fillable = array(
		'name', 'location', 'page', 'zone', 'status', 'credits',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'name', 'location', 'page', 'zone', 'status', 'credits',
		'created_at', 'updated_at',
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
			// Get all the item locations
			$widgets = static::active()->get()->toSimpleArray('id', 'location');

			// Create a new finder and filter the results
			$finder = Finder::create()->directories()->in(APPPATH."widgets")
				->filter(function(SplFileInfo $fileinfo) use ($widgets)
				{
					if (in_array($fileinfo->getRelativePathName(), $widgets))
					{
						return false;
					}
				});

			// Loop through the directories and install
			foreach ($finder as $f)
			{
				// Assign our path to a variable
				$file = APPPATH."widgets/".$f->getRelativePathName()."/widget.json";

				// Make sure the file exists first
				if (File::exists($file))
				{
					// Get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content, true);

					// Create the item
					static::create([
						'name'		=> $data->name,
						'location'	=> $data->location,
						'page'		=> $data->page,
						'zone'		=> $data->zone,
						'status'	=> Status::ACTIVE,
						'credits'	=> $data->credits
					]);
				}
			}
		}
		else
		{
			// Assign our path to a variable
			$file = APPPATH."widgets/{$location}/widget.json";
			
			// Make sure the file exists first
			if (File::exists($file))
			{
				// Get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content, true);
				
				// Create the item
				static::create([
					'name'		=> $data->name,
					'location'	=> $data->location,
					'page'		=> $data->page,
					'zone'		=> $data->zone,
					'status'	=> Status::ACTIVE,
					'credits'	=> $data->credits
				]);
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
	public function getQuickInstallFile($file = 'widget.json')
	{
		// Set the filename
		$filename = APPPATH."widgets/{$this->location}/{$file}";
		
		if (File::exists($filename))
		{
			// Get the contents of the QuickInstall file
			$contents = File::get($filename);

			return json_decode($contents);
		}

		return false;
	}

}