<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\General;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Data\SystemDefaults;
use Nova\Settings\Models\Settings;

class PopulateSettingsTable extends Migration
{
    public function up()
    {
        $settings = [
            'general' => new General(),
            'email' => new Email(),
            'system_defaults' => new SystemDefaults(
                iconSet: 'fluent',
                theme: 'Pulsar'
            ),
            'meta_tags' => new MetaTags(),
            'characters' => Characters::from([
                'allowCharacterCreation' => true,
                'allowSettingPrimaryCharacter' => false,
                'autoLinkCharacter' => true,
                'characterLimit' => 5,
                'enforceCharacterLimits' => true,
                'requireApprovalForCharacterCreation' => false,
            ]),
            'discord' => Discord::from([
                'webhook' => null,
                'color' => '#38b2ac',
            ]),
            'posting_activity' => new PostingActivity(
                postsStrategy: 'author',
                requiredActivity: 1000,
                trackingStrategy: 'words',
                wordCountPostConversion: 500,
                wordCountStrategy: 'average'
            ),
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
