<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Laratrust\Models\Permission as LaratrustPermission;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Roles\Models\Builders\PermissionBuilder;

class Permission extends LaratrustPermission
{
    use HasTableHelpers;

    protected $fillable = ['name', 'display_name', 'description'];

    public function newEloquentBuilder($query): PermissionBuilder
    {
        return new PermissionBuilder($query);
    }
}
