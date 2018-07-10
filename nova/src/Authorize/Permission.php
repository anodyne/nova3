<?php namespace Nova\Authorize;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
	use LogsActivity, PresentableTrait;

	protected $fillable = ['name', 'key'];
	protected $presenter = Presenters\PermissionPresenter::class;
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
