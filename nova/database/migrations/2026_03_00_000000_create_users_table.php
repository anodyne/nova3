<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('status')->index();
            $table->json('pronouns');
            $table->rememberToken();
            $table->boolean('force_password_reset')->default(false);
            $table->dateTime('email_verified_at')->nullable();
            $table->json('preferences')->nullable();
            $table->json('moderations')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->dateTime('created_at')->nullable();
        });

        Schema::create('logins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->string('ip_address', 50);
            $table->dateTime('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logins');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
