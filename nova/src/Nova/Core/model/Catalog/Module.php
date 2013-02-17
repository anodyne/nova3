<?php
/**
 * Module Catalog Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Catalog;

class Module extends \Model implements \QuickInstallInterface {
	
	protected $table = 'catalog_modules';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'short_name' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'protected' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'credits' => array(
			'type' => 'text',
			'null' => true),
	);
	
	/**
	 * Get all the modules from the catalog.
	 *
	 * @api
	 * @param	string	the status of modules
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE)
	{
		return static::query()->where('status', $status)->get();
	}

	/**
	 * Implement the QuickInstall interface.
	 */
	public static function install($location = null)
	{
		if ($location === null)
		{
			// get a listing of all modules
			$dir = \File::read_dir(APPPATH.'modules');

			// get all the installed modules
			$modules = static::getItems();

			if (count($modules) > 0)
			{
				// start by removing anything that's already installed
				foreach ($modules as $module)
				{
					if (array_key_exists($module->location.DS, $dir))
					{
						unset($dir[$module->location.DS]);
					}
				}
			}
				
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				try
				{
					// get the list of files for the module's migrations
					$moddir = \File::read_dir(APPPATH.'modules/'.$key.'migrations');

					// if we have migration files, do the module install
					if (count($moddir) > 0)
					{
						// clean the key
						$clean_key = str_replace(DS, '', $key);

						// run the migration
						\Migrate::latest($clean_key, 'module');
					}
				}
				catch (\Fuel\Core\InvalidPathException $e)
				{
					// we have no migrations to run for this module
				}

				// assign our path to a variable
				$file = APPPATH.'modules/'.$key.'module.json';
				
				// make sure the QI file exists first
				if (file_exists($file))
				{
					// get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);
					
					// create the item
					static::createItem($data);
				}
			}
		}
		else
		{
			try
			{
				// get the list of files for the module's migrations
				$dir = \File::read_dir(APPPATH.'modules/'.$location.'/migrations');

				// if we have migration files, do the module install
				if (count($dir) > 0)
				{
					\Migrate::latest($location, 'module');
				}
			}
			catch (\Fuel\Core\InvalidPathException $e)
			{
				// we have no migrations to run for this module
			}

			// assign our path to a variable
			$file = APPPATH.'modules/'.$location.'/module.json';
			
			// make sure the QI file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				// create the item
				static::createItem($data);
			}
		}
	}
	
	public static function uninstall($location)
	{
		throw new \Exception('Uninstall method is not implemented.');
	}
}
