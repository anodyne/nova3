<?php

use Nova\Themes\Models\Theme;
use Illuminate\Database\Migrations\Migration;

class PopulateThemesTable extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $themes = [
            ['name' => 'Pulsar', 'location' => 'pulsar', 'preview' => 'preview.jpg'],
            ['name' => 'Titan', 'location' => 'titan', 'preview' => 'preview.jpg'],
        ];

        collect($themes)->each([Theme::class, 'create']);

        activity()->enableLogging();
    }

    public function down()
    {
        Theme::truncate();
    }
}
