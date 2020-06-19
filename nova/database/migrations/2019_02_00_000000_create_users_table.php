<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('pronouns')->default('neutral');
            $table->string('status');
            $table->rememberToken();
            $table->boolean('force_password_reset')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();

            $table->index('email');
        });

        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('ip_address', 50);
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logins');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
    }
}
