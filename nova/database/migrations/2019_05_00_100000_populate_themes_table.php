<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Data\FontFamilies;
use Nova\Setup\Randomize;
use Nova\Themes\Data\ThemeSettings;
use Nova\Themes\Models\Theme;

class PopulateThemesTable extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $themes = [
            [
                'name' => 'Pulsar',
                'location' => 'Pulsar',
                'version' => '3.0',
                'preview' => 'preview.jpg',
                'settings' => new ThemeSettings(
                    fonts: new FontFamilies(
                        headerProvider: 'local',
                        headerFamily: Randomize::publicHeaderFont(),
                        bodyProvider: 'local',
                        bodyFamily: Randomize::publicBodyFont()
                    ),
                    settings: [
                        'accentColor' => '#08a37e',
                        'textAccentColor' => '#ffffff',
                    ],
                ),
            ],
            ['name' => 'Event Horizon', 'location' => 'EventHorizon', 'version' => '1.0', 'preview' => 'preview.jpg', 'settings' => new ThemeSettings(
                fonts: new FontFamilies(
                    headerProvider: 'local',
                    headerFamily: Randomize::publicHeaderFont(),
                    bodyProvider: 'local',
                    bodyFamily: Randomize::publicBodyFont()
                ),
                settings: []
            )],

            ['name' => 'Titan', 'location' => 'Titan', 'version' => '3.0', 'preview' => 'preview.jpg', 'settings' => new ThemeSettings(
                fonts: new FontFamilies(
                    headerProvider: 'bunny',
                    headerFamily: 'Antonio',
                    bodyProvider: 'local',
                    bodyFamily: Randomize::publicBodyFont()
                ),
                settings: []
            )],
            ['name' => 'Cerritos', 'location' => 'Cerritos', 'version' => '1.0', 'preview' => 'preview.jpg', 'settings' => new ThemeSettings(
                fonts: new FontFamilies(
                    headerProvider: 'bunny',
                    headerFamily: 'Antonio',
                    bodyProvider: 'local',
                    bodyFamily: Randomize::publicBodyFont()
                ),
                settings: []
            )],
            ['name' => 'Celestial', 'location' => 'Celestial', 'version' => '1.0', 'preview' => 'preview.jpg', 'settings' => new ThemeSettings(
                fonts: new FontFamilies(
                    headerProvider: 'local',
                    headerFamily: Randomize::publicHeaderFont(),
                    bodyProvider: 'local',
                    bodyFamily: Randomize::publicBodyFont()
                ),
                settings: []
            )],
        ];

        collect($themes)->each([Theme::class, 'create']);

        activity()->enableLogging();
    }

    public function down()
    {
        Theme::truncate();
    }
}
