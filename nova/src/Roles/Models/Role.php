<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laratrust\Models\Role as LaratrustRole;
use Nova\Roles\Events;
use Nova\Roles\Models\Builders\RoleBuilder;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Role extends LaratrustRole
{
    use HasEagerLimit;
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'default' => 'boolean',
        'locked' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => Events\RoleCreated::class,
        'deleted' => Events\RoleDeleted::class,
        'updated' => Events\RoleUpdated::class,
    ];

    protected $fillable = [
        'name', 'display_name', 'description', 'default', 'sort',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.display_name role was {$eventName}"
            );
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
    public function getMorphByUserRelation(string $relationship): MorphToMany
    {
        return parent::getMorphByUserRelation($relationship)
            // ->whereState('status', Active::class)
            ->orderBy('name');
    }

    public function giveToUser(User $user): self
    {
        $user->addRole($this);

        return $this;
    }

    public function newEloquentBuilder($query): RoleBuilder
    {
        return new RoleBuilder($query);
    }
}
