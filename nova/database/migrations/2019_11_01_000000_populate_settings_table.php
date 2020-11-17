<?php

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Models\Settings;
use Nova\Settings\Values\Defaults;
use Nova\Settings\Values\Discord;

class PopulateSettingsTable extends Migration
{
    public function up()
    {
        $settings = [
            'general' => [],
            'email' => [],
            'defaults' => new Defaults([
                'theme' => 'Pulsar',
                'iconSet' => 'fluent',
            ]),
            'meta_data' => [],
            'characters' => [],
            'discord' => new Discord([
                'storyPostsEnabled' => true,
                'storyPostsWebhook' => null,
                'storyPostsColor' => '#406ceb',
                'applicationsEnabled' => false,
                'applicationsWebhook' => null,
                'applicationsColor' => null,
            ]),
        ];

        $defaults = new Settings(array_merge([
            'key' => 'default',
        ], $settings));
        $defaults->save();

        $custom = new Settings(array_merge([
            'key' => 'custom',
        ], $settings));
        $custom->save();
    }

    public function down()
    {
        Settings::truncate();
    }
}
