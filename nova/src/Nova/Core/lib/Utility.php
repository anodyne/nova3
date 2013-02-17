<?php
/**
 * The Utility class contains methods for a wide variety of operations that need
 * to be completed throughout the system.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Core\Lib;

use App;
use Cache;
use Route;
use Sentry;
use Redirect;
use Exception;
use SystemModel;
use SettingsModel;
use Fuel\Util\Arr;

class Utility {
	
	/**
	 * Pulls the image index arrays from the base as well as the current skin.
	 *
	 * <code>
	 * $image_index = Utility::getImageIndex('default');
	 * </code>
	 *
	 * @api
	 * @param	string	the current skin
	 * @return 	array
	 */
	public static function getImageIndex($skin)
	{
		return array();
		
		// load the image index from the nova module first
		$common_path = \Finder::search('views', 'nova::images');
		$common_index = \Fuel::load($common_path);
		
		// load the current skin's image index (if it has one)
		$skin_path = \Finder::search('views', $skin.'/images');
		$skin_index = ($skin_path !== false) ? \Fuel::load($skin_path) : array();
		
		// merge the files into an array
		$image_index = array_merge( (array) $common_index, (array) $skin_index);
		
		return $image_index;
	}

	/**
	 * Get the current rank set, whether it's the user's preference or the
	 * system default.
	 *
	 * @api
	 * @return	string
	 */
	public static function getRank()
	{
		if (Sentry::check())
		{
			return Sentry::user()->get()->getPreferences('rank');
		}

		return SettingsModel::getItems('rank');
	}

	/**
	 * Get the current skin for a given section, whether it's the user's
	 * preference or the system default.
	 *
	 * @api
	 * @param	string	the section
	 * @return	string
	 */
	public static function getSkin($section)
	{
		if (Sentry::check())
		{
			return Sentry::user()->get()->getPreferences('skin_'.$section);
		}

		return SettingsModel::getItems('skin_'.$section);
	}

	/**
	 * Check for updates to the system.
	 *
	 * 0 - no updates
	 * 1 - major update (3.0 => 4.0)
	 * 2 - minor update (3.0 => 3.1)
	 * 3 - incremental update (3.0.1 => 3.0.2)
	 *
	 * @api
	 * @return 	mixed	false if there are no updates, an object with information if there are
	 */
	public static function getUpdates()
	{
		if (ini_get('allow_url_fopen'))
		{
			// grab the update setting preference
			$pref = \Model_Settings::getItems('updates');
			
			// get the ignore version info
			$sys = \Model_System::find('first');
			
			// load the nova config file
			\Config::load('nova::nova', 'nova');
			
			// load the data
			$content = file_get_contents(\Config::get('nova.version_info'));
			
			// parse the content
			$US = json_decode($content);

			if ($US !== null)
			{
				// if the admin has ignored this version, stop execution
				if (version_compare($US->version, $sys->version_ignore, '=='))
				{
					return false;
				}
				
				// build the system version string
				$sysversion = $sys->version_major.'.'.$sys->version_minor.'.'.$sys->version_update;
				
				// check the version in the system versus what's coming from the update server
				if (version_compare($sysversion, $US->version, '<'))
				{
					// if the admin wants to see these specific updates, pass the object along
					if ($US->severity <= $pref)
					{
						return $US;
					}
					
					return false;
				}
			}

			return false;
		}
		
		return false;
	}

	/**
	 * Checks to see if the system is installed.
	 *
	 * If the system is installed, we'll cache the result so that subsequent 
	 * checks will be a lot faster. In the event the user is in the setup module, 
	 * the cache will be wiped out to avoid throwing some nasty exceptions.
	 *
	 * @return	bool
	 */
	public static function installed()
	{
		// Get the environment
		$env = App::make('env');

		// Get the path info from the Request object
		$path = Route::getRequest()->getPathInfo();

		// Make sure the database config file is there first
		if ( ! file_exists(APPPATH."config/{$env}/database.php"))
		{
			// Make sure we take in to account the controllers this needs to ignore
			if (stristr($path, 'setup/') === false)
			{
				return Redirect::to('setup/main/config');
			}
		}
		else
		{
			// Wipe out the system install cache if we're in the setup module
			if (stristr($path, 'setup/') !== false)
			{
				Cache::forget('nova_system_installed');
			}

			/**
			 * Since we only ever cache the install status when the system is
			 * actually installed, we can just assume here that if an
			 * exception isn't thrown that the system is installed.
			 */
			$status = Cache::get('nova_system_installed');

			// If the status is null, we know it doesn't exist
			if ($status === null)
			{
				// Grab the UID
				$uid = SystemModel::getUniqueId();

				// Only cache if we have a UID and we aren't in the setup module
				if ( ! empty($uid) and stristr($path, 'setup/') === false)
				{
					Cache::forever('nova_system_installed', (int) true);

					return true;
				}

				return false;
			}

			return $status;
		}

		return false;
	}

	/**
	 * Get the public ip address of the user.
	 *
	 * @author	FuelPHP Development Team
	 * @return  string
	 */
	public static function ip($default = '0.0.0.0')
	{
		return static::server('REMOTE_ADDR', $default);
	}

	/**
	 * Get the real ip address of the user.  Even if they are using a proxy.
	 *
	 * @author	FuelPHP Development Team
	 * @param	string	the default to return on failure
	 * @param	bool	exclude private and reserved IPs
	 * @return  string  the real ip address of the user
	 */
	public static function realIp($default = '0.0.0.0', $excludeReserved = false)
	{
		$serverKeys = array('HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR');

		foreach ($serverKeys as $key)
		{
			if ( ! static::server($key))
			{
				continue;
			}

			$ips = explode(',', static::server($key));
			array_walk($ips, function (&$ip) {
				$ip = trim($ip);
			});

			$ips = array_filter($ips, function($ip) use($excludeReserved) {
				return filter_var($ip, FILTER_VALIDATE_IP, $excludeReserved ? FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE : null);
			});

			if ($ips)
			{
				return reset($ips);
			}
		}

		return $default;
	}

	/**
	 * Fetch an item from the SERVER array
	 *
	 * @author	FuelPHP Development Team
	 * @param   string  The index key
	 * @param   mixed   The default value
	 * @return  string|array
	 */
	public static function server($index = null, $default = null)
	{
		return (func_num_args() === 0) ? $_SERVER : Arr::get($_SERVER, strtoupper($index), $default);
	}
}
