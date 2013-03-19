<?php namespace Nova\Core\Model\Catalog;

use Model;
use Status;
use Exception;
use CatalogSkinSecModel;
use QuickInstallInterface;

class Skin extends Model implements QuickInstallInterface {

	protected $table = 'catalog_skins';
	
	protected static $properties = array(
		'id', 'name', 'location', 'credits', 'version', 'created_at', 'updated_at',
	);

	public static $_has_many = array(
		'sections' => array(
			'model_to' => '\\Model_Catalog_SkinSec',
			'key_to' => 'skin',
			'key_from' => 'location',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
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
			// get the listing of the directory
			$dir = self::directory_list(APPPATH.'views/');
			
			// get all the skin catalogue items
			$skins = Model_CatalogueSkin::getItems();
			
			if (count($skins) > 0)
			{
				// start by removing anything that's already installed
				foreach ($skins as $skin)
				{
					// find the location in the directory listing
					$key = array_search($skin->location, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
				
				// create an array of items to remove
				$pop = array('template.php');
				
				// remove the items
				foreach ($pop as $p)
				{
					// find the location in the directory listing
					$key = array_search($p, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
				
				// now loop through the directories and install the skins
				foreach ($dir as $key => $value)
				{
					// assign our path to a variable
					$file = APPPATH.'views/'.$value.'/skin.json';
					
					// make sure the file exists first
					if (file_exists($file))
					{
						$content = file_get_contents($file);
						$data = json_decode($content);
						
						$data_skin = array(
							'name' => $data->name,
							'location' => $data->location,
							'credits' => $data->credits,
							'version' => $data->version
						);
						
						// create the skin
						Model_CatalogueSkin::add($data_skin);
						
						// go through and add the sections
						foreach ($data->sections as $v)
						{
							$data_section = array(
								'section' => $v->type,
								'skin' => $data->location,
								'preview' => $v->preview,
								'status' => 'active',
								'default' => 0
							);
							
							// create the section
							Model_CatalogueSkinSec::add($data_section);
						}
					}
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'views/'.$location.'/skin.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				$data_skin = array(
					'name' => $data->name,
					'location' => $data->location,
					'credits' => $data->credits,
					'version' => $data->version
				);
				
				// create the skin
				Model_CatalogueSkin::add($data_skin);
				
				// go through and add the sections
				foreach ($data->sections as $v)
				{
					$data_section = array(
						'section' => $v->type,
						'skin' => $data->location,
						'preview' => $v->preview,
						'status' => 'active',
						'default' => 0
					);
					
					// create the section
					Model_CatalogueSkinSec::add($data_section);
				}
			}
		}
		*/
	}

	public static function uninstall($location)
	{
		throw new Exception('Uninstall method is not implemented.');
	}

}