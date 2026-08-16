<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laratrust\Models\Role as LaratrustRole;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Roles\Events\RoleCreated;
use Nova\Roles\Events\RoleDeleted;
use Nova\Roles\Events\RoleUpdated;
use Nova\Roles\Models\Builders\RoleBuilder;
use Nova\Users\Models\States\Status\Active;
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
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static RoleBuilder<static>|Role atOrAboveOrderColumn($maxSortValue)
 * @method static RoleBuilder<static>|Role atOrBelowOrderColumn($maxSortValue)
 * @method static \Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static RoleBuilder<static>|Role isDefault()
 * @method static RoleBuilder<static>|Role newModelQuery()
 * @method static RoleBuilder<static>|Role newQuery()
 * @method static RoleBuilder<static>|Role ordered(string $direction = 'asc')
 * @method static RoleBuilder<static>|Role query()
 * @method static RoleBuilder<static>|Role searchFor($search)
 * @method static RoleBuilder<static>|Role whereCreatedAt($value)
 * @method static RoleBuilder<static>|Role whereDescription($value)
 * @method static RoleBuilder<static>|Role whereDisplayName($value)
 * @method static RoleBuilder<static>|Role whereId($value)
 * @method static RoleBuilder<static>|Role whereIsDefault($value)
 * @method static RoleBuilder<static>|Role whereIsLocked($value)
 * @method static RoleBuilder<static>|Role whereName($value)
 * @method static RoleBuilder<static>|Role whereOrderColumn($value)
 * @method static RoleBuilder<static>|Role wherePrefixedId($value)
 * @method static RoleBuilder<static>|Role whereUpdatedAt($value)
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

    protected $fillable = [
        'name', 'display_name', 'description', 'is_default', 'order_column', 'is_locked',
    ];

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
}
