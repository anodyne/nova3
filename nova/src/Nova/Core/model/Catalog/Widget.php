<?php namespace Nova\Core\Model\Catalog;

use Model;
use Status;
use Exception;
use QuickInstallInterface;

class Widget extends Model implements QuickInstallInterface {
	
	protected $table = 'catalog_widgets';
	
	protected static $properties = array(
		'id', 'name', 'location', 'page', 'zone', 'status', 'credits',
		'created_at', 'updated_at',
	);
	
	/**
	 * Get all items from the catalog.
	 *
	 * @param	string	The status to pull
	 * @return	Collection
	 */
	public static function getItems($status = Status::ACTIVE)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		if ( ! empty($status))
		{
			$query->where('status', $status);
		}

		return $query->get();
	}

	public static function install($location = false)
	{
		return true;
		/*
		if ($location === null)
		{
			// get the directory listing
			$dir = self::directory_list(MODPATH.'app/views/components/widget/');
			
			// get all the installed widgets
			$widgets = Model_CatalogueWidget::getItems();
			
			if (count($widgets) > 0)
			{
				// start by removing anything that's already installed
				foreach ($widgets as $w)
				{
					// find the location in the directory listing
					$key = array_search($w->location, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
			}
			
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				// assign our path to a variable
				$file = MODPATH.'app/views/components/widget/'.$value.'/widget.json';
				
				// make sure the file exists first
				if (file_exists($file))
				{
					// get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);
					
					$data_widget = array(
						'name'		=> $data->name,
						'location'	=> $data->location,
						'page'		=> $data->page,
						'zone'		=> $data->zone,
						'status'	=> 'active',
						'credits'	=> $data->credits
					);
					
					// create the item
					Model_CatalogueWidget::createItem($data_widget);
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = MODPATH.'app/views/components/widget/'.$location.'/widget.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				$data_widget = array(
					'name'		=> $data->name,
					'location'	=> $data->location,
					'page'		=> $data->page,
					'zone'		=> $data->zone,
					'status'	=> 'active',
					'credits'	=> $data->credits
				);
				
				// create the item
				Model_CatalogueWidget::createItem($data_widget);
			}
		}
		*/
	}

	public static function uninstall($location)
	{
		throw new Exception('Uninstall method is not implemented.');
	}

}