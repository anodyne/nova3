<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Models\Settings;
use Nova\Settings\Values\Characters;
use Nova\Settings\Values\Defaults;
use Nova\Settings\Values\Discord;
use Nova\Settings\Values\Email;
use Nova\Settings\Values\General;

class PopulateSettingsTable extends Migration
{
    public function up()
    {
        $settings = [
            'general' => new General([]),
            'email' => new Email([]),
            'defaults' => new Defaults([
                'theme' => 'Pulsar',
                'iconSet' => 'fluent',
            ]),
            'meta_data' => [],
            'characters' => new Characters([
                'allowCharacterCreation' => true,
                'requireApprovalForCharacterCreation' => true,
                'enforceCharacterLimits' => true,
                'characterLimit' => 5,
            ]),
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
