<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_notifications');
        Schema::dropIfExists('discussion_messages');
        Schema::dropIfExists('discussions');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->nullableMorphs('discussable');
            $table->string('subject')->nullable();
            $table->datetimes();
        });

        Schema::create('discussion_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->longText('content');
            $table->string('type')->default('text');
            $table->datetimes();
        });

        Schema::create('discussion_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('discussion_message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->boolean('is_seen')->default(false);
            $table->boolean('is_sender')->default(false);
            $table->datetimes();
            $table->softDeletesDatetime();

            $table->index(['user_id', 'discussion_message_id'], 'participant_message_index');
        });

        Schema::create('discussion_participant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->datetimes();
            $table->softDeletesDatetime();

            $table->unique(['discussion_id', 'user_id'], 'discussion_participants_index');
        });
    }
};
