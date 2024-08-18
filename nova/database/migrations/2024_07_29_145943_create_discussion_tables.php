<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Models\Discussion;
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
            $table->morphs('discussable');
            $table->timestamps();
        });

        Schema::create('discussion_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Discussion::class);
            $table->foreignIdFor(User::class);
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_messages');
        Schema::dropIfExists('discussions');
    }
};
