<?php

use Nova\Themes\Models\Theme;
use Illuminate\Database\Migrations\Migration;

class PopulateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        activity()->disableLogging();

        $themes = [
            ['name' => 'Pulsar', 'location' => 'pulsar'],
            ['name' => 'Titan', 'location' => 'titan'],
        ];

        collect($themes)->each(function ($theme) {
            Theme::create($theme);
        });

        activity()->enableLogging();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
