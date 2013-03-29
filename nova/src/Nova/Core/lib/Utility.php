<?php namespace Nova\Core\Lib;

use App;
use File;
use Cache;
use Route;
use Config;
use Sentry;
use System;
use Request;
use Settings;
use Redirect;
use Exception;

class Utility {
	
	/**
	 * Pulls the image index arrays from the base as well as the current skin.
	 *
	 * <code>
	 * $imageIndex = Utility::getImageIndex('default');
	 * </code>
	 *
	 * @param	string	The current skin
	 * @return 	array
	 */
	public static function getImageIndex($skin)
	{
		return array();

		// Load the image index from the core first
		$commonIndex = include_once SRCPATH.'Core/views/images.php';

		// Now load the image index from the skin (if it has one)
		$skinIndex = (File::exists(APPPATH."views/{$skin}/images.php"))
			? include_once APPPATH."views/{$skin}/images.php"
			: array();
		
		// Merge the files into an array
		$imageIndex = array_merge((array) $commonIndex, (array) $skinIndex);
		
		return $imageIndex;
	}

	/**
	 * Get the current rank set, whether it's the user's preference or the
	 * system default.
	 *
	 * @return	string
	 */
	public static function getRank()
	{
		if (Sentry::check())
		{
			return Sentry::getUser()->getPreferenceItem('rank');
		}

		return Settings::getItems('rank');
	}

	/**
	 * Get the current skin for a given section, whether it's the user's
	 * preference or the system default.
	 *
	 * @param	string	The section
	 * @return	string
	 */
	public static function getSkin($section)
	{
		if (Sentry::check())
		{
			return Sentry::getUser()->getPreferenceItem("skin_{$section}");
		}

		return Settings::getItems("skin_{$section}");
	}

	/**
	 * Check for updates to the system.
	 *
	 * 0 - no updates
	 * 1 - major update (3.0 => 4.0)
	 * 2 - minor update (3.0 => 3.1)
	 * 3 - incremental update (3.0.1 => 3.0.2)
	 *
	 * @return 	object|bool
	 */
	public static function getUpdates()
	{
		if (ini_get('allow_url_fopen'))
		{
			// Get the ignore version info
			$sys = System::first();

			// Load the data
			$content = File::getRemote(Config::get('nova.version_check_path'));

			// Parse the content
			$updateServer = json_decode($content);

			if ($updateServer !== null)
			{
				// Grab the update setting preference
				$updatePref = (int) Settings::getItems('updates');

				// If the admin has ignored this version, stop execution
				if (version_compare($updateServer->version, $sys->version_ignore, '=='))
				{
					return false;
				}
				
				// Build the system version string
				$sysVersion = $sys->version_major.'.'.$sys->version_minor.'.'.$sys->version_update;

				// Check the version in the system versus what's coming from the update server
				if (version_compare($sysVersion, $updateServer->version, '<'))
				{
					// If the admin wants to see these specific updates, pass the object along
					if ($updateServer->severity <= $updatePref)
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
		if ( ! File::exists(APPPATH.'config/'.App::environment().'/database.php'))
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
			if (Request::is('setup*') and File::exists(APPPATH.'storage/cache/nova_system_installed'))
			{
				Cache::forget('nova_system_installed');
			}

			// Get the install status from the cache
			$status = Cache::get('nova_system_installed');

			// If the status is null, we know it doesn't exist
			if ($status === null)
			{
				try
				{
					// Grab the UID
					$uid = System::getUniqueId();

					// Only cache if we have a UID
					if ( ! empty($uid))
					{
						Cache::forever('nova_system_installed', (int) true);

						return true;
					}
				}
				catch (Exception $e)
				{
					return false;
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
	 * Get the real ip address of the user. Even if they are using a proxy.
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
