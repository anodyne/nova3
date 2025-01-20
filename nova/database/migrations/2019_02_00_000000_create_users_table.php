<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('status')->index();
            $table->json('pronouns');
            $table->rememberToken();
            $table->boolean('force_password_reset');
            $table->timestamp('email_verified_at')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();

            $table->index('email');
        });

        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('ip_address', 50);
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logins');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
}
