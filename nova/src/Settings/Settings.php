<?php namespace Nova\Settings;

use Eloquent;

class Settings extends Eloquent
{
	protected $fillable = ['key', 'value'];
	protected $table = 'settings';

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function scopeItem($query, $key)
	{
		return $query->where('key', $key);
	}
}
