<?php
/**
 * The Utility class contains methods for a wide variety of operations that need
 * to be completed throughout the system.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

namespace Nova\Core\Lib;

use App;
use Cache;
use Route;
use Config;
use Sentry;
use Request;
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
			return Sentry::getUser()->getPreferenceItem('rank');
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
			return Sentry::getUser()->getPreferenceItem("skin_{$section}");
		}

		return SettingsModel::getItems("skin_{$section}");
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
	 * @return 	object|bool
	 */
	public static function getUpdates()
	{
		if (ini_get('allow_url_fopen'))
		{
			// Grab the update setting preference
			$pref = SettingsModel::getItems('updates');
			
			// Get the ignore version info
			$sys = SystemModel::find('first');
			
			// Load the data
			$content = file_get_contents(Config::get('nova.version_check_path'));
			
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
				$sysVersion = $sys->version_major.'.'.$sys->version_minor.'.'.$sys->version_update;
				
				// check the version in the system versus what's coming from the update server
				if (version_compare($sysVersion, $US->version, '<'))
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
		// Make sure the database config file is there first
		if ( ! file_exists(APPPATH.'config/'.App::environment().'/database.php'))
		{
			// Make sure we take in to account the controllers this needs to ignore
			if ( ! Request::is('setup/*'))
			{
				return Redirect::to('setup/config');
			}
		}
		else
		{
			// Wipe out the system install cache if we're in the setup module
			if (Request::is('setup/*'))
			{
				Cache::forget('nova_system_installed');
			}

			// Get the install status from the cache
			$status = Cache::get('nova_system_installed');

			// If the status is null, we know it doesn't exist
			if ($status === null)
			{
				// Grab the UID
				$uid = SystemModel::getUniqueId();

				// Only cache if we have a UID and we aren't in the setup module
				if ( ! empty($uid) and ! Request::is('setup/*'))
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
	 * Get the public IP address of the user.
	 *
	 * @return  string
	 */
	public static function ip()
	{
		return Request::server('REMOTE_ADDR');
	}

	/**
	 * Get the real ip address of the user.  Even if they are using a proxy.
	 *
	 * @author	FuelPHP Development Team
	 * @param	string	The default to return on failure
	 * @param	bool	Exclude private and reserved IPs
	 * @return  string
	 */
	public static function realIp($default = '0.0.0.0', $excludeReserved = false)
	{
		$serverKeys = array('HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR');

		foreach ($serverKeys as $key)
		{
			if ( ! Request::server($key))
			{
				continue;
			}

			$ips = explode(',', Request::server($key));

			array_walk($ips, function (&$ip)
			{
				$ip = trim($ip);
			});

			$ips = array_filter($ips, function($ip) use($excludeReserved)
			{
				return filter_var($ip, FILTER_VALIDATE_IP, $excludeReserved ? FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE : null);
			});

			if ($ips)
			{
				return reset($ips);
			}
		}

		return $default;
	}
}
