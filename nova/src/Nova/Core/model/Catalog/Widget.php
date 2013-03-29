<?php namespace Nova\Core\Model\Catalog;

use Model;
use Status;
use QuickInstallInterface;

class Widget extends Model implements QuickInstallInterface {
	
	protected $table = 'catalog_widgets';

	protected $fillable = array(
		'name', 'location', 'page', 'zone', 'status', 'credits',
	);
	
	protected static $properties = array(
		'id', 'name', 'location', 'page', 'zone', 'status', 'credits',
		'created_at', 'updated_at',
	);

	/**
	 * Scope the query to active widgets.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeActive($query)
	{
		$query->where('status', Status::ACTIVE);
	}

	/**
	 * Scope the query to inactive widgets.
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
					static::add(array(
						'name'		=> $data->name,
						'location'	=> $data->location,
						'page'		=> $data->page,
						'zone'		=> $data->zone,
						'status'	=> Status::ACTIVE,
						'credits'	=> $data->credits
					));
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
				static::add(array(
					'name'		=> $data->name,
					'location'	=> $data->location,
					'page'		=> $data->page,
					'zone'		=> $data->zone,
					'status'	=> Status::ACTIVE,
					'credits'	=> $data->credits
				));
			}
		}
	}

	/**
	 * Uninstall via QuickInstall.
	 *
	 * @param	string	A specific location to uninstall
	 * @return	void
	 */
	public static function uninstall($location = true)
	{
		if ( ! $location)
		{
			// Get all the item locations
			$widgets = static::get();

			// Loop through the widgets and remove them
			foreach ($widgets as $w)
			{
				$w->delete();
			}
		}
		else
		{
			// Remove the item from the database
			$item = static::remove(array('location' => $location));
		}
	}

}