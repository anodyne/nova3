<?php namespace Nova\Core\Lib;

use URL;
use HTML;
use File;
use View;
use Config;
use Exception;
use RankCatalog;

class Location {

	/**
	 * @var	string	The file name.
	 */
	protected $file;

	/**
	 * @var	string	The current skin.
	 */
	protected $skin;

	/**
	 * @var	string	The type of asset.
	 */
	protected $type;

	/**
	 * @var	string	The fallback module.
	 */
	protected $module;

	/**
	 * Find an ajax view.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function ajax($file)
	{
		return $this->file($file, 'ajax');
	}

	/**
	 * Finds and returns the path to an asset image. Asset images are not part
	 * of seamless substitution since they're stored entirely outside of the 
	 * Nova core.
	 *
	 * @param	string	Name and extension of the image
	 * @param	string	What to return (image, path, abspath, urlpath)
	 * @param	array 	Array of attributes to be used on the image
	 * @param	string	The module to fallback to
	 * @return	string
	 */
	public function asset($image, $return = 'image', $attr = array(), $module = 'core')
	{
		$this->file = $image;
		$this->type = 'asset';
		$this->module = $module;

		return $this->findImage($return, $attr);
	}

	/**
	 * Searches to find where to pull the specified email from. If the email 
	 * exists in the override module (app/modules/override), it'll use that 
	 * and stop searching. Otherwise, it'll use whatever's found in the Nova 
	 * module.
	 *
	 * @param	string	File
	 * @param	string	Email format (html/text)
	 * @return	string
	 */
	public function email($file, $format, $module = 'core')
	{
		$this->file = $file;
		$this->type = "email/{$format}";
		$this->module = $module;

		return $this->findEmail();
	}

	/**
	 * Find an error view.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function error($file)
	{
		return $this->file($file, 'error');
	}

	/**
	 * Searches to find where to pull the specified file from. If the file 
	 * exists in the skin, it'll use that that one and stop searching. If the 
	 * file exists in the override module (app/modules/override), it'll use that 
	 * and stop searching. Otherwise, it'll use whatever's found in the Nova 
	 * module.
	 *
	 * @param	string	File
	 * @param	string	Current skin
	 * @param	string	Type of file (structure, template, partial, pages, js)
	 * @return	string
	 */
	public function file($file, $type)
	{
		$this->file = $file;
		$this->skin = $this->setSkin();
		$this->type = $type;

		return $this->findFile();
	}

	/**
	 * Finds and returns the path to an image. Nova will first look inside the
	 * current skin to find the image. If the image is found, it'll use that
	 * and stop looking, otherwise it'll move on to the override module and
	 * check there. Again, if the image is found, it'll use that and stop looking,
	 * otherwise it'll finally look in the nova module and use that image.
	 *
	 * @param	string	The name of the image
	 * @param	string	The name of the skin
	 * @param	string	The fallback module
	 * @param	string	What to return (image, path, abspath, urlpath)
	 * @param	array 	An array of attributes to be used on the image
	 * @return	string
	 */
	public function image($image, $return = 'image', $attr = array(), $module = 'core')
	{
		$this->file = $image;
		$this->skin = $this->setSkin();
		$this->type = 'image';
		$this->module = $module;

		return $this->findImage($return, $attr);
	}

	/**
	 * Find a js view.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function js($file)
	{
		return $this->file($file, 'js');
	}

	/**
	 * Find a page view.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function page($file)
	{
		return $this->file($file, 'page');
	}

	/**
	 * Find a partial.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function partial($file)
	{
		return $this->file($file, 'partial');
	}

	/**
	 * Finds and returns the path to a rank image (app/assets/common/{GENRE}/ranks).
	 * Rank images are not part of seamless substitution since they're stored
	 * entirely outside of the Nova core.
	 *
	 * @param	string	The name of the base image
	 * @param	string	The name of the pip image
	 * @param	string	The location of the rank set
	 * @return	string
	 */
	public function rank($base, $pip, $location = false)
	{
		$this->file = false;
		$this->skin = false;
		$this->type = 'rank';

		return $this->findRank($base, $pip, $location);
	}

	/**
	 * Find a structure view.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function structure($file)
	{
		return $this->file($file, 'structure');
	}

	/**
	 * Find a template view.
	 *
	 * @param	string	File
	 * @return	string
	 */
	public function template($file)
	{
		return $this->file($file, 'template');
	}

	/**
	 * Find the right path to an email view.
	 *
	 * @return	string
	 */
	protected function findEmail()
	{
		return "components/{$this->type}/{$this->file}";
	}

	/**
	 * Find the right path to a view.
	 *
	 * @return	string
	 */
	protected function findFile()
	{
		if (File::exists(APPPATH."modules/override/views/components/{$this->type}/{$this->file}.php")
				or File::exists(APPPATH."modules/override/views/components/{$this->type}/{$this->file}.blade.php"))
		{
			return "components/{$this->type}/{$this->file}";
		}
		elseif (File::exists(APPPATH."views/{$this->skin}/components/{$this->type}/{$this->file}.php")
				or File::exists(APPPATH."views/{$this->skin}/components/{$this->type}/{$this->file}.blade.php"))
		{
			return "{$this->skin}/components/{$this->type}/{$this->file}";
		}
		
		return "components/{$this->type}/{$this->file}";
	}

	/**
	 * Find the right path to an image.
	 *
	 * @param	string	What to return (image, urlpath, abspath, path)
	 * @param	array	Attributes for the image return type
	 * @return	string
	 */
	protected function findImage($return = 'path', $attributes = array())
	{
		// Find the path to the image
		$path = $this->findAssetPath();

		switch ($return)
		{
			case 'image':
				// Set the ALT attribute to the image name if it isn't set already
				$attributes['alt'] = ( ! array_key_exists('alt', $attributes)) ? $this->file : $attributes['alt'];

				return HTML::image($path, null, $attributes);
			break;

			case 'urlpath':
				return URL::asset($path);
			break;

			case 'abspath':
				return APPPATH.str_replace('app/', '', $path);
			break;

			default:
				return $path;
			break;
		}
	}

	/**
	 * Find the right path to a rank.
	 *
	 * @param	string	The base image
	 * @param	string	The pip image
	 * @param	string	An optional rank location
	 * @return	string
	 */
	protected function findRank($base, $pip, $location = false)
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		// Get the rank catalog object
		$catalog = ( ! $location)
			? RankCatalog::getItems('location', \Utility::getRank())->first()
			: RankCatalog::getItems('location', $location)->first();

		if (File::isDirectory(APPPATH."assets/common/{$genre}/ranks/{$catalog->location}/base") 
				and File::isDirectory(APPPATH."assets/common/{$genre}/ranks/{$catalog->location}/pips"))
		{
			// Set the base path for the ranks
			$basePath = "app/assets/common/{$genre}/ranks/{$catalog->location}";

			// Set the base and pip image paths
			$baseImage = URL::asset("{$basePath}/base/{$base}{$catalog->extension}");
			$pipImage = URL::asset("{$basePath}/pips/{$pip}{$catalog->extension}");
			
			// Set up the properties
			$properties = array(
				'base' => "background:transparent url({$baseImage}) no-repeat top left;",
				'pip' => "background:transparent url({$pipImage}) no-repeat top left;",
			);

			return View::make($this->partial('common/rank'))
				->with('props', $properties)
				->render();
		}

		// Clean up the base
		$base = str_replace('cadet/', '', $base);

		// Clean up the pip
		$pip = (strpos($pip, '/') !== false) ? substr_replace($pip, '', 0, (strpos($pip, '/') + 1)) : $pip;

		// Set the image name now
		$imageName = (empty($pip)) ? $base.$catalog->extension : $base."-".$pip.$catalog->extension;

		// Return the old rank style
		return HTML::image("app/assets/common/{$genre}/ranks/{$catalog->location}/{$imageName}", null);
	}

	/**
	 * Executes the search and return of images from the file system. Alias
	 * methods exist to interact with this since it uses dynamic arguments to
	 * make the API a little cleaner.
	 *
	 * @internal
	 * @return	string	The path to the asset
	 * @throws	Exception
	 */
	protected function findAssetPath()
	{
		switch ($this->type)
		{
			case 'asset':
				return "app/assets/images/{$this->file}";
			break;
			
			case 'image':
				if (File::exists(APPPATH."modules/override/views/design/images/{$this->file}"))
				{
					return "app/modules/override/views/design/images/{$this->file}";
				}
				elseif (File::exists(APPPATH."views/{$this->skin}/design/images/{$this->file}"))
				{
					return "app/views/{$this->skin}/design/images/{$this->file}";
				}
				
				return "nova/src/nova/".strtolower($this->module)."/views/design/images/{$this->file}";
			break;
			
			case 'rank':
				return "app/assets/common/".Config::get('nova.genre')."/ranks/{$args[1]}/{$args[2]}";
			break;
			
			default:
				throw new Exception(lang('error.exception.invalid_image'));
			break;
		}
	}

	/**
	 * Set the skin.
	 *
	 * @internal
	 * @return	void
	 */
	protected function setSkin()
	{
		$this->skin = \Utility::getSkin();
	}
	
}