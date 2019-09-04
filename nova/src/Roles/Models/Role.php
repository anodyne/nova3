<?php

namespace Nova\Roles\Models;

use Nova\Roles\Events;
use Spatie\Activitylog\Traits\LogsActivity;
use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $dispatchesEvents = [
        'created' => Events\RoleCreated::class,
        'updated' => Events\RoleUpdated::class,
        'deleted' => Events\RoleDeleted::class,
    ];

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
