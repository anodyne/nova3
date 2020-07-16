<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaratrustTables extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->boolean('default')->default(false);
            $table->boolean('locked')->default(false);
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('user_type');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('user_type');

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });

        Schema::create('permission_role', function (Blueprint $table) {
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
    }
}
