<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;

class CreateFormTables extends Migration
{
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('type');
            $table->text('description')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->json('options')->nullable();
            $table->longText('fields')->nullable();
            $table->longText('published_fields')->nullable();
            $table->string('status')->default(FormStatus::Active->value);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->index(['name', 'key']);
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Form::class);
            $table->string('name');
            $table->string('uid');
            $table->string('label');
            $table->string('type');
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Form::class);
            $table->nullableMorphs('owner');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('form_submission_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FormSubmission::class, 'submission_id');
            $table->string('field_type');
            $table->string('field_uid');
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('form_submission_responses');
        Schema::dropIfExists('forms');
    }
}
