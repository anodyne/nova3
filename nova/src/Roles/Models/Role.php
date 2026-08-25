<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Database\Factories\RoleFactory;
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
use Nova\Users\Models\User;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @mixin IdeHelperRole
 */
#[UseEloquentBuilder(RoleBuilder::class)]
class Role extends LaratrustRole implements Sortable
{
    /** @use HasFactory<RoleFactory> */
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
    /**
     * @return MorphToMany<User, $this>
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
