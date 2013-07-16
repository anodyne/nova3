<?php namespace Nova\Core\Models\Entities\Catalog;

use File;
use Model;
use Status;
use SplFileInfo;
use QuickInstallInterface;
use Symfony\Component\Finder\Finder;

class Skin extends Model implements QuickInstallInterface {

	protected $table = 'catalog_skins';

	protected $fillable = [
		'name', 'location', 'nav', 'preview', 'credits', 'version', 'status', 
		'options', 'has_main', 'has_admin', 'has_login',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'name', 'location', 'nav', 'preview', 'credits', 'version', 
		'status', 'options', 'has_main', 'has_admin', 'has_login', 'created_at', 
		'updated_at',
	];

	/*
	|--------------------------------------------------------------------------
	| Models Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to skins that have a main section.
	 *
	 * @param	Builder		Query Builder
	 * @return	void
	 */
	public function scopeHasMain($query)
	{
		$query->where('has_main', (int) true);
	}

	/**
	 * Scope the query to skins that have an admin section.
	 *
	 * @param	Builder		Query Builder
	 * @return	void
	 */
	public function scopeHasAdmin($query)
	{
		$query->where('has_admin', (int) true);
	}

	/**
	 * Scope the query to skins that have a log in section.
	 *
	 * @param	Builder		Query Builder
	 * @return	void
	 */
	public function scopeHasLogin($query)
	{
		$query->where('has_login', (int) true);
	}

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
					static::create([
						'name'		=> $data->name,
						'location'	=> $data->location,
						'nav'		=> $data->nav,
						'preview'	=> $data->preview,
						'credits'	=> $data->credits,
						'version'	=> $data->version,
						'status'	=> Status::ACTIVE,
					]);
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
				static::create([
					'name'		=> $data->name,
					'location'	=> $data->location,
					'nav'		=> $data->nav,
					'preview'	=> $data->preview,
					'credits'	=> $data->credits,
					'version'	=> $data->version,
					'status'	=> Status::ACTIVE,
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
		// Get all the items
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
		$this->delete();
	}

}