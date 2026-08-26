<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('character_id')->nullable()->constrained();
            $table->string('ip_address')->nullable();
            $table->string('result')->default('pending');
            $table->longText('decision_message')->nullable();
            $table->dateTime('decision_date')->nullable();
            $table->timestamps();

            $table->index('result');
        });

        Schema::create('application_review', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->string('result')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();

            $table->index('application_id');
            $table->index(['application_id', 'user_id']);
            $table->index('result');
            $table->index(['application_id', 'result']);
        });

        Schema::create('application_reviewers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained();
            $table->string('type')->default('conditional');
            $table->json('conditions')->nullable();
            $table->timestamps();

            $table->index('type');
        });
    }
};
