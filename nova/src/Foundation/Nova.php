<?php

namespace Nova\Foundation;

class Nova
{
	use Concerns\DoesEnvironmentChecks,
		Concerns\DoesSystemChecks,
		Concerns\DoesVersionChecks,
		Concerns\ProvidesScriptVariables;

	/**
	 * The Nova version.
	 */
	public $version = '3.0.0-alpha.2';
	public $fileVersion = '3.0.0-alpha.2';
}
