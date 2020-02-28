<?php

namespace Nova\Roles\Models;

use Nova\Roles\Events;
use Nova\Users\Models\User;
use Laratrust\Models\LaratrustRole;
use Nova\Roles\Models\Builders\RoleBuilder;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Role extends LaratrustRole
{
    use LogsActivity;
    use HasEagerLimit;

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
        return ":subject.display_name role was {$eventName}";
    }

    /**
     * Morph by Many relationship between the role and the one of the possible
     * user models.
     *
     * NOTE: This method is being overridden by Nova to ensure we always return
     * the users for a role in alphabetical order.
     *
     * @param  string  $relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function getMorphByUserRelation($relationship)
    {
        return parent::getMorphByUserRelation($relationship)
            ->orderBy('name');
    }

    /**
     * Give the role to a specific user.
     *
     * @param  User  $user
     *
     * @return Role
     */
    public function giveToUser(User $user)
    {
        $user->attachRole($this);

        return $this;
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return RoleBuilder
     */
    public function newEloquentBuilder($query): RoleBuilder
    {
        return new RoleBuilder($query);
    }
}
