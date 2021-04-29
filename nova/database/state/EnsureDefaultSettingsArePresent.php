<?php

namespace Database\State;

use Illuminate\Support\Facades\DB;
use Nova\Settings\Models\Settings;
use Nova\Settings\Values;

class EnsureDefaultSettingsArePresent
{
    public function __invoke()
    {
        if ($this->present()) {
            return;
        }

        $settings = [
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

        $defaults = new Settings(array_merge([
            'key' => 'default',
        ], $settings));
        $defaults->save();
    }

    private function present(): bool
    {
        return DB::table('settings')->whereKey('default')->count() > 0;
    }
}
