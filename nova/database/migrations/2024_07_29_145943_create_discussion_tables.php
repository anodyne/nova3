<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Discussions\Enums\MessageType;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Users\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->nullableMorphs('discussable');
            $table->string('name')->nullable();
            $table->boolean('is_direct_message')->default(false);
            $table->text('direct_message_participants')->nullable();
            $table->timestamps();
        });

        Schema::create('discussion_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Discussion::class)->onDelete('cascade');
            $table->foreignIdFor(User::class)->nullable()->onDelete('set null');
            $table->longText('content');
            $table->string('type')->default(MessageType::Text->value);
            $table->timestamps();
        });

        Schema::create('discussion_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Discussion::class)->onDelete('cascade');
            $table->foreignIdFor(DiscussionMessage::class)->onDelete('cascade');
            $table->foreignIdFor(User::class);
            $table->boolean('is_seen')->default(false);
            $table->boolean('is_sender')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'discussion_message_id'], 'participant_message_index');
        });

        Schema::create('discussion_participant', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Discussion::class)->onDelete('cascade');
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['discussion_id', 'user_id'], 'discussion_participants_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_notifications');
        Schema::dropIfExists('discussion_messages');
        Schema::dropIfExists('discussions');
    }
};
