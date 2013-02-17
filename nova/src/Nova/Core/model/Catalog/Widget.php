<?php
/**
 * Widgets Catalog Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Catalog;

class Widget extends \Model implements \QuickInstallInterface {
	
	protected $table = 'catalog_widgets';
	
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
		'page' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'zone' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'credits' => array(
			'type' => 'text',
			'null' => true),
	);
	
	/**
	 * Get all items from the catalog.
	 *
	 * @api
	 * @param	string	the status to pull
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE)
	{
		$status_where = ( ! empty($status)) ? array('status', $status) : array();
		
		$result = static::query()
			->where($status_where)
			->get();
			
		return $result;
	}

	public static function install($location = null)
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
		throw new \Exception('Uninstall method is not implemented.');
	}
}
