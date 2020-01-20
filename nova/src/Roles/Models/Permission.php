<?php

namespace Nova\Roles\Models;

use Laratrust\Models\LaratrustPermission;
use Nova\Roles\Models\Builders\PermissionBuilder;

class Permission extends LaratrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return PermissionBuilder
     */
    public function newEloquentBuilder($query): PermissionBuilder
    {
        return new PermissionBuilder($query);
    }
}
