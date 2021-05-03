<?php

use Illuminate\Database\Migrations\Migration;
use Nova\Roles\Models\Role;

class PopulateInitialRoles extends Migration
{
    public function up(): void
    {
        Role::unguarded(function () {
            collect([
                ['name' => 'admin', 'display_name' => 'System Admin', 'locked' => true, 'sort' => 0],
                ['name' => 'user', 'display_name' => 'Active User', 'default' => true, 'sort' => 1],
            ])->each([Role::class, 'create']);
        });
    }

    public function down(): void
    {
        Role::whereIn('name', ['admin', 'user'])->delete();
    }
}
