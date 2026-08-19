<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Carbon\CarbonImmutable;
use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laratrust\Models\Role as LaratrustRole;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Events\RoleDeleted;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Models\Builders\RoleBuilder;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property bool $is_default
 * @property bool $is_locked
 * @property int|null $order_column
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, User> $user
 * @property-read int|null $user_count
 *
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role atOrAboveOrderColumn($maxSortValue)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role atOrBelowOrderColumn($maxSortValue)
 * @method static RoleFactory factory($count = null, $state = [])
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role isDefault()
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role newModelQuery()
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role newQuery()
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role ordered(string $direction = 'asc')
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role query()
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role searchFor($search)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereCreatedAt($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereDescription($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereDisplayName($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereId($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereIsDefault($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereIsLocked($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereName($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereOrderColumn($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role wherePrefixedId($value)
 * @method static RoleBuilder<static>|\Nova\Roles\Models\Role whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(RoleBuilder::class)]
class Role extends LaratrustRole implements Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasTableHelpers;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'is_default' => 'boolean',
        'is_locked' => 'boolean',
        'order_column' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => RoleCreated::class,
        'deleted' => RoleDeleted::class,
        'updated' => RoleUpdated::class,
    ];

    protected $fillable = [
        'name', 'display_name', 'description', 'is_default', 'order_column', 'is_locked',
    ];

    /**
     * Morph by Many relationship between the role and the one of the possible
     * user models.
     *
     * NOTE: This method is being overridden by Nova to ensure we always return
     * the users for a role in alphabetical order.
     */
    public function getMorphByUserRelation(string $relationship): MorphToMany
    {
        return parent::getMorphByUserRelation($relationship)
            // ->whereState('status', Active::class)
            ->orderBy('name');
    }

    /**
     * @return MorphToMany<User, $this>
     */
    public function user(): MorphToMany
    {
        /** @var MorphToMany<User, $this> $morphToMany */
        $morphToMany = $this->getMorphByUserRelation('user');

        return $morphToMany;
    }
}
