<?php

use Illuminate\Database\Migrations\Migration;
use Nova\Themes\Models\Theme;

class PopulateInitialThemes extends Migration
{
    public function up(): void
    {
        Theme::unguarded(function () {
            collect([
                ['name' => 'Pulsar', 'location' => 'pulsar', 'preview' => 'preview.jpg'],
                ['name' => 'Titan', 'location' => 'titan', 'preview' => 'preview.jpg'],
            ])->each([Theme::class, 'create']);
        });
    }

    public function down(): void
    {
        Theme::whereIn('location', ['pulsar', 'titan'])->delete();
    }
}
