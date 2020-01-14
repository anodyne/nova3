<?php

namespace Nova\Roles\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];
}
