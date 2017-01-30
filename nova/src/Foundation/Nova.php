<?php namespace Nova\Foundation;

use Status;

class Nova {

	use Configuration\DoesEnvironmentChecks,
		Configuration\DoesSystemChecks,
		Configuration\DoesVersionCheck,
		Configuration\ProvidesScriptVariables;

	/**
	 * The Nova version.
	 */
	public static $version;
	public static $fileVersion = '3.0.0-alpha4';

	public static function startup()
	{
		$info = app('nova.system');

		static::$version = implode('.', [
			$info->version_major,
			$info->version_minor,
			$info->version_patch
		]);
	}
}
