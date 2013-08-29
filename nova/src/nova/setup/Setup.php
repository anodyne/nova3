<?php namespace nova\setup;

use File;
use Cache;
use Config;
use System;
use Request;
use Settings;
use Redirect;
use Exception;

class Setup {

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
	public function getUpdates()
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
				$updatePref = (int) Settings::getSettings('updates');

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
					// Get the ignore version
					$ignoreVersion = System::first()->ignore;

					// If the admin wants to ignore this version, bail
					if (version_compare($ignoreVersion, $updateServer->version, '=='))
					{
						return false;
					}

					// If the admin wants to see these specific updates, pass the object along
					if ($updateServer->severity <= $updatePref)
					{
						return $updateServer;
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
	public function installed($cache = true)
	{
		// Get the system install status cache file
		$status = Cache::get('nova.installed');

		if ($status === null)
		{
			try
			{
				// Grab the UID
				$uid = System::getUniqueId();

				// Only cache if we have a UID
				if ( ! empty($uid) and $cache === true)
				{
					Cache::forever('nova.installed', (int) true);
				}

				return true;
			}
			catch (Exception $e)
			{
				// Make sure we take in to account the controllers this needs to ignore
				if ( ! Request::is('setup*'))
				{
					return Redirect::to('setup');
				}

				return false;
			}
		}

		return (bool) $status;
	}

	public function register()
	{
		if (in_array('curl', get_loaded_extensions()))
		{
			/*Httpful::post(Config::get('nova.registration_path'))
				->body(array(
					'url'		=> Request::url(),
					'version'	=> Config::get('nova.app.version'),
				))
				->sendsXml();
				->send();*/
		}
	}

}