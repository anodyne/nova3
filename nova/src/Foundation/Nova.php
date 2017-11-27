<?php namespace Nova\Foundation;

class Nova
{
	use Configuration\DoesEnvironmentChecks,
		Configuration\DoesSystemChecks,
		Configuration\DoesVersionChecks,
		Configuration\ProvidesScriptVariables;

	/**
	 * The Nova version.
	 */
	public $version = '3.0.0-alpha.1';
	public $fileVersion = '3.0.0-alpha.1';
}
