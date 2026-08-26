<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->string('name')->index();
            $table->string('key')->unique();
            $table->string('type');
            $table->text('description')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->json('options')->nullable();
            $table->longText('fields')->nullable();
            $table->longText('published_fields')->nullable();
            $table->string('status')->default('active')->index();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('form_id')->constrained();
            $table->string('name');
            $table->string('uid');
            $table->string('label');
            $table->string('type');
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('form_id')->constrained();
            $table->nullableUuidMorphs('owner');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('form_submission_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('submission_id')->constrained('form_submissions');
            $table->string('field_type');
            $table->string('field_uid');
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('form_submission_responses');
        Schema::dropIfExists('forms');
    }
};
