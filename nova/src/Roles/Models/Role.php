<?php

namespace Nova\Roles\Models;

use Nova\Roles\Events;
use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole
{

    protected $dispatchesEvents = [
        'created' => Events\Created::class,
        'updated' => Events\Updated::class,
        'deleted' => Events\Deleted::class,
        'replicated' => Events\Duplicated::class,
    ];
}