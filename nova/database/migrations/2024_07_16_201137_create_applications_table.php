<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Character::class)->nullable();
            $table->string('ip_address')->nullable();
            $table->string('result')->default(ApplicationResult::Pending->value);
            $table->longText('decision_message')->nullable();
            $table->dateTime('decision_date')->nullable();
            $table->timestamps();
        });

        Schema::create('application_review', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Application::class);
            $table->foreignIdFor(User::class);
            $table->string('result')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('application_reviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('type')->default(ReviewerType::Conditional->value);
            $table->json('conditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_review');
        Schema::dropIfExists('applications');
    }
};
