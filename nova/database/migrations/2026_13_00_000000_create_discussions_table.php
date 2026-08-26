<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->prefixedId();
            $table->nullableUuidMorphs('discussable');
            $table->string('subject')->nullable();
            $table->timestamps();
        });

        Schema::create('discussion_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('discussion_id')->constrained();
            $table->foreignUuid('user_id')->nullable()->constrained();
            $table->longText('content');
            $table->string('type')->default('text');
            $table->timestamps();
        });

        Schema::create('discussion_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('discussion_id')->constrained();
            $table->foreignUuid('discussion_message_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->boolean('is_seen');
            $table->boolean('is_sender');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'discussion_message_id'], 'participant_message_index');
        });

        Schema::create('discussion_participant', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('discussion_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['discussion_id', 'user_id'], 'discussion_participants_index');
        });
    }
};
