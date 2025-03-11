<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Enums\ReviewerType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('character_id')->nullable()->constrained();
            $table->string('ip_address')->nullable();
            $table->string('result')->default(ApplicationResult::Pending->value);
            $table->longText('decision_message')->nullable();
            $table->dateTime('decision_date')->nullable();
            $table->timestamps();

            $table->index('result');
        });

        Schema::create('application_review', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('result')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();

            $table->index('application_id');
            $table->index(['application_id', 'user_id']);
            $table->index('result');
            $table->index(['application_id', 'result']);
        });

        Schema::create('application_reviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type')->default(ReviewerType::Conditional->value);
            $table->json('conditions')->nullable();
            $table->timestamps();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_reviewers');
        Schema::dropIfExists('application_review');
        Schema::dropIfExists('applications');
    }
};
