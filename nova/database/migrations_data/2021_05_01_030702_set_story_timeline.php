<?php

use Illuminate\Database\Migrations\Migration;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\Story;

class SetStoryTimeline extends Migration
{
    public function up(): void
    {
        Story::create([
            'title' => 'Main Timeline',
            'status' => Completed::class,
        ]);
    }

    public function down(): void
    {
        Story::truncate();
    }
}
