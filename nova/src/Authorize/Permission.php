<?php namespace Nova\Authorize;

use Eloquent;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Eloquent
{
	use LogsActivity;

	protected $fillable = ['name', 'key'];
	protected $table = 'permissions';

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'permissions_roles');
	}

	//--------------------------------------------------------------------------
	// Activity Logging
	//--------------------------------------------------------------------------

	protected static $logAttributes = ['name', 'key'];

	public function getDescriptionForEvent(string $eventName): string
	{
		return "Permission :subject.name was {$eventName}";
	}

	public function getLogNameToUse(string $eventName = ''): string
	{
		return 'nova-authorize';
	}
}
