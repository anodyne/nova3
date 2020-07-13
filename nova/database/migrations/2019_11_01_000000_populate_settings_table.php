<?php

use Nova\Settings\Models\Settings;
use Illuminate\Database\Migrations\Migration;
use Nova\Settings\DataTransferObjects\DefaultsSettings;
use Nova\Settings\DataTransferObjects\EmailSettings;

class PopulateSettingsTable extends Migration
{
    public function up()
    {
        $settings = [
            'general' => [],
            'email' => [],
            'defaults' => new DefaultsSettings([
                'theme' => 'Pulsar',
                'iconSet' => 'fluent',
            ]),
            'meta_data' => [],
            'characters' => [],
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
