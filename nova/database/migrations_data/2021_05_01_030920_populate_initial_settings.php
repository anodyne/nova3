<?php

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Models\Settings;
use Nova\Settings\Values;

class PopulateInitialSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Settings::unguarded(function () {
            collect([
                $this->defaultSettings('default'),
                $this->defaultSettings('custom'),
            ])->each([Settings::class, 'create']);
        });
    }

    public function down(): void
    {
        Settings::truncate();
    }

    public function defaultSettings($key): array
    {
        return [
            'key' => $key,
            'general' => new Values\General([]),
            'email' => new Values\Email([]),
            'defaults' => new Values\Defaults([
                'theme' => 'Pulsar',
                'iconSet' => 'fluent',
            ]),
            'meta_data' => [],
            'characters' => new Values\Characters([
                'allowCharacterCreation' => true,
                'requireApprovalForCharacterCreation' => true,
                'enforceCharacterLimits' => true,
                'characterLimit' => 5,
            ]),
            'discord' => new Values\Discord([
                'storyPostsEnabled' => true,
                'storyPostsWebhook' => null,
                'storyPostsColor' => '#406ceb',
                'applicationsEnabled' => false,
                'applicationsWebhook' => null,
                'applicationsColor' => null,
            ]),
        ];
    }
}
