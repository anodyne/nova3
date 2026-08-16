<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Laratrust\Models\Permission as LaratrustPermission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Roles\Models\Builders\PermissionBuilder;

/**
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static PermissionBuilder<static>|Permission newModelQuery()
 * @method static PermissionBuilder<static>|Permission newQuery()
 * @method static PermissionBuilder<static>|Permission query()
 * @method static PermissionBuilder<static>|Permission searchFor($search)
 * @method static PermissionBuilder<static>|Permission whereCreatedAt($value)
 * @method static PermissionBuilder<static>|Permission whereDescription($value)
 * @method static PermissionBuilder<static>|Permission whereDisplayName($value)
 * @method static PermissionBuilder<static>|Permission whereId($value)
 * @method static PermissionBuilder<static>|Permission whereName($value)
 * @method static PermissionBuilder<static>|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(PermissionBuilder::class)]
class Permission extends LaratrustPermission
{
    use HasTableHelpers;
    use LogsActivity;

    protected $fillable = ['name', 'display_name', 'description'];
}
