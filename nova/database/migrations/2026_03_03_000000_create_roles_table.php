<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('laratrust.tables.roles'), function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name')->unique();
            $table->string('display_name')->nullable()->index();
            $table->string('description')->nullable();
            $table->boolean('is_default')->index();
            $table->boolean('is_locked');
            $table->unsignedInteger('order_column')->nullable();
            $table->datetimes();
        });

        Schema::create(config('laratrust.tables.permissions'), function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable()->index();
            $table->string('description')->nullable();
            $table->datetimes();
        });

        Schema::create(config('laratrust.tables.teams'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->datetimes();
        });

        Schema::create(config('laratrust.tables.role_user'), function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('user_type');
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');

            // $table->primary(['user_id', 'role_id', 'user_type']);
            $table->unique(['user_id', 'role_id', 'user_type', 'team_id']);
        });

        Schema::create(config('laratrust.tables.permission_user'), function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('user_type');
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');

            // $table->primary(['user_id', 'permission_id', 'user_type']);
            $table->unique(
                ['user_id', 'permission_id', 'user_type', 'team_id'],
                'permission_user_user_id_permission_id_user_type_team_id'
            );
        });

        Schema::create(config('laratrust.tables.permission_role'), function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('teams');
    }
};
