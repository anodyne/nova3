<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\AuthorizationType;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class CreateLaratrustTables extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name')->unique();
            $table->string('display_name')->nullable()->index();
            $table->string('description')->nullable();
            $table->boolean('is_default')->default(false)->index();
            $table->boolean('is_locked')->default(false);
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable()->index();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignIdFor(Role::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(User::class)->constrained();
            $table->string('user_type');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignIdFor(Permission::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(User::class)->constrained();
            $table->string('user_type');

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignIdFor(Permission::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Role::class)->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        // Schema::create('authorizations', function (Blueprint $table) {
        //     $table->id();
        //     $table->morphs('authorizable');
        //     $table->string('type')->default(AuthorizationType::policy->value);
        //     $table->string('value')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        // Schema::dropIfExists('authorizations');
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
