<?php namespace Nova\Foundation;

use Eloquent;

class SystemInfo extends Eloquent
{
	protected $fillable = ['version'];
	protected $table = 'system_info';

	//--------------------------------------------------------------------------
	// Methods
	//--------------------------------------------------------------------------

	public function setVersion($version)
	{
		$this->version = $version;
		$this->save();
	}
}
