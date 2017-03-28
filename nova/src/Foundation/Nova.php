<?php namespace Nova\Foundation;

class Nova
{
	use Configuration\DoesEnvironmentChecks,
		Configuration\DoesSystemChecks,
		Configuration\DoesVersionCheck,
		Configuration\ProvidesScriptVariables;

	/**
	 * The Nova version.
	 */
	public $version;
	public $fileVersion = '3.0.0-alpha4';

	public function startup()
	{
		$info = app('nova.system');

		$this->version = implode('.', [
			$info->version_major,
			$info->version_minor,
			$info->version_patch
		]);
	}
}
