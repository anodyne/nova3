<?php

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Models\LaratrustPermission;
use Nova\Roles\Models\Builders\PermissionBuilder;

class Permission extends LaratrustPermission
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'description'];

    public function newEloquentBuilder($query): PermissionBuilder
    {
        return new PermissionBuilder($query);
    }
}
