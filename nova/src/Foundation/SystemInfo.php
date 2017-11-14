<?php namespace Nova\Foundation;

use Eloquent;

class SystemInfo extends Eloquent
{
	protected $fillable = [
		'version', 'install_phase', 'migration_phase', 'update_phase'
	];
	protected $table = 'system_info';

	//--------------------------------------------------------------------------
	// Methods
	//--------------------------------------------------------------------------

	public function setPhase($type, $phase)
	{
		$phaseType = "{$type}_phase";

		$this->{$phaseType} = $phase;
		$this->save();
	}

	public function setVersion($version)
	{
		$this->version = $version;
		$this->save();
	}
}
