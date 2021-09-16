<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\DataTransferObjects\Characters;
use Nova\Settings\DataTransferObjects\Discord;
use Nova\Settings\DataTransferObjects\Email;
use Nova\Settings\DataTransferObjects\General;
use Nova\Settings\DataTransferObjects\MetaTags;
use Nova\Settings\DataTransferObjects\PostingActivity;
use Nova\Settings\DataTransferObjects\SystemDefaults;
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
            'characters' => new Characters(
                allowCharacterCreation: true,
                requireApprovalForCharacterCreation: true,
                enforceCharacterLimits: true,
                characterLimit: 5
            ),
            'discord' => new Discord(
                storyPostsEnabled: true,
                storyPostsWebhook: null,
                storyPostsColor: '#406ceb',
                applicationsEnabled: false,
                applicationsWebhook: null,
                applicationsColor: null
            ),
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
