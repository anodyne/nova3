<?php namespace Nova\Core\Models\Eloquent\Catalog;

use File;
use Model;
use Config;
use Status;
use SplFileInfo;
use MediaInterface;
use QuickInstallInterface;
use Symfony\Component\Finder\Finder;

class Skin extends Model implements QuickInstallInterface, MediaInterface {

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

	/**
	 * Scope the query to a skin by location.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeLocation($query, $location)
	{
		$query->where('location', $location);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Accessors and Mutators
	|--------------------------------------------------------------------------
	*/

	/**
	 * When the options attribute is called, unserialize the data and return it
	 * as an array.
	 *
	 * @param	string	Attribute value
	 * @return	array
	 */
	public function getOptionsAttribute($value)
	{
		return unserialize($value);
	}

	/**
	 * When the options attribute is stored, serialize the data.
	 *
	 * @param	array	Options array
	 * @return	void
	 */
	public function setOptionsAttribute($value)
	{
		$this->attributes['options'] = serialize($value);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$a = Config::get('app.aliases');

		// Setup the listeners
		//static::setupEventListeners($a['SkinCatalogModel'], $a['SkinCatalogModelEventHandler']);
	}

	/**
	 * Check to see if the current skin has an updates available. This only
	 * applies to skins that use QuickInstall.
	 *
	 * @return	bool
	 */
	public function checkForUpdate()
	{
		// Get the skin object from the QuickInstall file
		$skin = $this->getQuickInstallFile('skin.json');

		if ($skin !== false)
		{
			if (version_compare($this->version, $skin->version, '<'))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Apply an update to the current skin. This only applies to skins that use
	 * QuickInstall.
	 *
	 * @return	bool
	 */
	public function applyUpdate()
	{
		// Get the skin object from the QuickInstall file
		$skin = $this->getQuickInstallFile('skin.json');

		if ($skin !== false)
		{
			// Get the options
			$options = $this->getQuickInstallFile('options.json');

			if ($options !== false)
			{
				// Get the options
				$originalOptions = $this->options;

				foreach ($originalOptions as $key => $option)
				{
					// Filter out everything but the key we're looking for
					$search = array_filter($options->items, function($e) use ($key)
					{
        				return $e->key == $key;
					});

					// If we have an empty array, it means the item is no longer
					// in the options file, so we'll remove it from the database
					if (count($search) == 0)
					{
						unset($originalOptions[$key]);
					}
				}

				// Set the options
				$this->options = $originalOptions;

				// Save the record
				$this->save();
			}

			// Update the skin catalog record
			$this->update([
				'name'		=> $skin->name,
				'location'	=> $skin->location,
				'nav'		=> $skin->nav,
				'preview'	=> $skin->preview,
				'credits'	=> $skin->credits,
				'version'	=> $skin->version,
				'has_main'	=> (int) $skin->has_main,
				'has_admin'	=> (int) $skin->has_admin,
				'has_login'	=> (int) $skin->has_login,
			]);

			return true;
		}

		return false;
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
			$finder = Finder::create()->directories()->in(static::getPath())
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
				$dir = static::getPath().$f->getRelativePathName();

				// Make sure the file exists first
				if (File::exists($dir."/skin.json"))
				{
					// Get the contents and decode the JSON
					$content = file_get_contents($dir."/skin.json");
					$data = json_decode($content);

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
			$dir = static::getPath().$location;

			// Make sure the file exists first
			if (File::exists($dir."/skin.json"))
			{
				// Get the contents and decode the JSON
				$content = file_get_contents($dir."/skin.json");
				$data = json_decode($content);
				
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

	/**
	 * Get the QuickInstall file.
	 *
	 * @param	string	File name
	 * @return	stdClass|bool
	 */
	public function getQuickInstallFile($file)
	{
		// Set the filename
		$filename = static::getPath()."{$this->location}/{$file}";

		if (File::exists($filename))
		{
			// Get the contents of the QuickInstall file
			$contents = File::get($filename);

			return json_decode($contents);
		}

		return false;
	}

	/**
	 * Get the path to where this resource is located.
	 *
	 * @return	string
	 */
	public static function getPath()
	{
		return APPPATH."skins/";
	}

	/*
	|--------------------------------------------------------------------------
	| Media Implementation
	|--------------------------------------------------------------------------
	*/

	public function addMedia($file, $options)
	{
		if (isset($options['key']))
		{
			// Get the options out of the model
			$originalOptions = $this->options;

			// Update the appropriate option
			$originalOptions[$options['key']] = $file;
			
			// Store the new options and save it
			$this->options = $originalOptions;
			$this->save();
		}
	}

}