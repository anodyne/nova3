<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Laratrust\Models\Permission as LaratrustPermission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Roles\Models\Builders\PermissionBuilder;

/**
 * @mixin IdeHelperPermission
 */
#[UseEloquentBuilder(PermissionBuilder::class)]
class Permission extends LaratrustPermission
{
    use HasTableHelpers;
    use LogsActivity;

    protected $fillable = ['name', 'display_name', 'description'];
}
