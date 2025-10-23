<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Setup\Randomize;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            'general' => [
                'gameName' => 'USS Nova',
                'contactFormEnabled' => true,
                'contactFormDisabledMessage' => 'We’re sorry, but the contact form is currently closed. Please try again at a later date.',
            ],
            'email' => [
                'subjectPrefix' => null,
                'replyTo' => null,
                'imagePath' => null,
            ],
            'appearance' => [
                'theme' => Randomize::theme(),
                'avatarShape' => Randomize::avatarShape(),
                'avatarStyle' => Randomize::avatarStyle(),
                'colorsGray' => 'Zinc',
                'colorsPrimary' => 'Sky',
                'colorsDanger' => 'Rose',
                'colorsWarning' => 'Amber',
                'colorsSuccess' => 'Emerald',
                'colorsInfo' => 'Purple',
                'adminFonts' => [
                    'headerProvider' => 'local',
                    'headerFamily' => 'Inter',
                    'bodyProvider' => 'local',
                    'bodyFamily' => 'Inter',
                ],
            ],
            'characters' => [
                'approvePrimary' => true,
                'approveSecondary' => true,
                'approveSupport' => true,
                'enforceCharacterLimits' => true,
                'characterLimit' => 5,
                'autoAvailabilityForPrimary' => true,
                'autoAvailabilityForSecondary' => true,
                'autoAvailabilityForSupport' => false,
            ],
            'discord' => [
                'webhook' => null,
                'color' => '#38b2ac',
            ],
            'posting_activity' => [
                'target' => 'words',
                'requirement' => 250,
                'timeframe' => 'rolling',
                'rollingDays' => 7,
            ],
            'ratings' => [
                'language' => [
                    'rating' => '1',
                    'description0' => 'Does not contain profanity',
                    'description1' => 'Infrequent, light profanity',
                    'description2' => 'Mild profanity',
                    'description3' => 'Heavy profanity and mature language',
                    'warningThreshold' => '2',
                    'warningThresholdMessage' => 'May contain heavy profanity and mature language',
                ],
                'sex' => [
                    'rating' => '1',
                    'description0' => 'Does not contain sexual content',
                    'description1' => 'Mild sexual innuendo and references',
                    'description2' => 'Sexual content and situations',
                    'description3' => 'Explicit sexual content',
                    'warningThreshold' => '2',
                    'warningThresholdMessage' => 'May contain explicit sexual content',
                ],
                'violence' => [
                    'rating' => '1',
                    'description0' => 'Does not contain violence',
                    'description1' => 'Mild violence',
                    'description2' => 'Heavy violence',
                    'description3' => 'Explicit violence',
                    'warningThreshold' => '2',
                    'warningThresholdMessage' => 'May contain explicit violence',
                ],
            ],
            'applications' => [
                'enabled' => true,
                'disabledMessage' => 'We’re sorry, but applications are currently closed. Please try again at a later date.',
                'alwaysShowResults' => false,
                'allowVoteChanging' => false,
                'showDecisionMessage' => true,
            ],
            'dashboard' => [
                'leaderboard' => [
                    'title' => 'Top Contributors',
                    'icon' => 'tabler-award',
                    'target' => 'words',
                    'userSelectableTimeframe' => false,
                    'timeframe' => '30-days',
                    'numberOfSpotsToShow' => 5,
                    'showRankNumbers' => false,
                    'hideUsersWithZero' => true,
                    'onlyActiveUsers' => true,
                    'enabled' => true,
                    'showPodium' => false,
                ],
                'milestonesTarget' => 'words',
            ],
        ];

        $now = Date::now();

        $encodedSettings = [];
        foreach ($settings as $column => $value) {
            $encodedSettings[$column] = is_array($value)
                ? json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
                : $value;
        }

        $base = [
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $rows = [
            array_merge($base, ['key' => 'default'], $encodedSettings),
            array_merge($base, ['key' => 'custom'], $encodedSettings),
        ];

        DB::transaction(fn () => DB::table('settings')->insert($rows));
    }

    public function down(): void
    {
        DB::table('settings')->truncate();
    }
};
