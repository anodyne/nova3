<?php namespace Nova\Core\Model\Catalog;

use File;
use Model;
use Status;
use SplFileInfo;
use QuickInstallInterface;
use Symfony\Component\Finder\Finder;
use SkinSectionCatalog as SkinSectionCatalogModel;

class Skin extends Model implements QuickInstallInterface {

	protected $table = 'catalog_skins';

	protected $fillable = array(
		'name', 'location', 'credits', 'version',
	);
	
	protected static $properties = array(
		'id', 'name', 'location', 'credits', 'version', 'created_at', 'updated_at',
	);

	/**
	 * Get the sections for this skin.
	 *
	 * @return	Collection
	 */
	public function sections()
	{
		return SkinSectionCatalogModel::where('skin', $this->location)->active()->get();
	}

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
			// Get all the skin locations
			$skins = static::active()->get()->toSimpleArray('id', 'location');

			// Create a new finder and filter the results
			$finder = Finder::create()->directories()->in(APPPATH."views")
				->filter(function(SplFileInfo $fileinfo) use ($skins)
				{
					if (in_array($fileinfo->getRelativePathName(), $skins))
					{
						return false;
					}
				});

			// Loop through the directories and install
			foreach ($finder as $f)
			{
				// Assign our path to a variable
				$dir = APPPATH."views/".$f->getRelativePathName();

				// Make sure the file exists first
				if (File::exists($dir."/skin.json"))
				{
					// Get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content, true);

					// Add the skin record
					static::add(array(
						'name'		=> $data->name,
						'location'	=> $data->location,
						'credits'	=> $data->credits,
						'version'	=> $data->version,
					));
					
					// Loop through and add the sections
					foreach ($data->sections as $s)
					{
						SkinSectionCatalogModel::add(array(
							'section' 	=> $s->type,
							'skin' 		=> $data->location,
							'preview'	=> $s->preview,
							'status' 	=> Status::ACTIVE,
							'default' 	=> (int) false
						));
					}
				}
			}
		}
		else
		{
			// Assign our path to a variable
			$dir = APPPATH."views/".$location;

			// Make sure the file exists first
			if (File::exists($dir."/skin.json"))
			{
				// Get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content, true);
				
				// Add the skin record
				static::add(array(
					'name'		=> $data->name,
					'location'	=> $data->location,
					'credits'	=> $data->credits,
					'version'	=> $data->version,
				));
				
				// Loop through and add the sections
				foreach ($data->sections as $s)
				{
					SkinSectionCatalogModel::add(array(
						'section' 	=> $s->type,
						'skin' 		=> $data->location,
						'preview'	=> $s->preview,
						'status' 	=> Status::ACTIVE,
						'default' 	=> (int) false
					));
				}
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
			// Get all the skin locations
			$skins = static::get();

			// Loop through the delete the skins
			foreach ($skins as $skin)
			{
				// Loop through the sections and remove them
				foreach ($skin->sections() as $sec)
				{
					$sec->delete();
				}

				// Remove the skin now
				$skin->delete();
			}
		}
		else
		{
			// Remove the skin sections
			$sections = SkinSectionCatalogModel::remove(array('location' => $location));

			// Remove the skin
			static::remove(array('location' => $location));
		}
	}

}