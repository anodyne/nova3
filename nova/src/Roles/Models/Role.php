<?php

namespace Nova\Roles\Models;

use Nova\Roles\Events;
use Laratrust\Models\LaratrustRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends LaratrustRole
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $dispatchesEvents = [
        'created' => Events\RoleCreated::class,
        'updated' => Events\RoleUpdated::class,
        'deleted' => Events\RoleDeleted::class,
    ];

    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.title role was {$eventName}";
    }
}
