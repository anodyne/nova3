<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Laratrust\Models\Permission as LaratrustPermission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Roles\Models\Builders\PermissionBuilder;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 *
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission newModelQuery()
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission newQuery()
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission query()
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission searchFor($search)
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission whereCreatedAt($value)
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission whereDescription($value)
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission whereDisplayName($value)
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission whereId($value)
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission whereName($value)
 * @method static PermissionBuilder<static>|\Nova\Roles\Models\Permission whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(PermissionBuilder::class)]
class Permission extends LaratrustPermission
{
    use HasTableHelpers;
    use LogsActivity;

    protected $fillable = ['name', 'display_name', 'description'];
}
