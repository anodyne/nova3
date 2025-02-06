<?php

declare(strict_types=1);

use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Applications;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRating;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\FontFamilies;
use Nova\Settings\Data\General;
use Nova\Settings\Data\Leaderboard;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Data\WritingDashboard;
use Nova\Settings\Enums\LeaderboardTimeframe;
use Nova\Settings\Enums\PostingTarget;
use Nova\Settings\Enums\PostingTimeframe;
use Nova\Settings\Models\Settings;
use Nova\Setup\Randomize;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    protected bool $async = false;

    protected string $queue = 'default';

    protected ?string $tag = null;

    public function process(): void
    {
        activity()->disableLogging();

        $settings = [
            'general' => new General(
                gameName: 'USS Nova',
                contactFormEnabled: true,
                contactFormDisabledMessage: 'We’re sorry, but the contact form is currently closed. Please try again at a later date.',
            ),
            'email' => new Email(
                subjectPrefix: null,
                replyTo: null,
                imagePath: null,
            ),
            'appearance' => new Appearance(
                theme: Randomize::theme(),
                avatarShape: Randomize::avatarShape(),
                avatarStyle: Randomize::avatarStyle(),
                imagePath: null,
                colorsGray: 'Gray',
                colorsPrimary: 'Sky',
                colorsDanger: 'Rose',
                colorsWarning: 'Amber',
                colorsSuccess: 'Emerald',
                colorsInfo: 'Purple',
                adminFonts: new FontFamilies(
                    headerProvider: 'local',
                    headerFamily: 'Inter',
                    bodyProvider: 'local',
                    bodyFamily: 'Inter'
                ),
                panda: false
            ),
            'meta_tags' => new MetaTags,
            'characters' => new Characters(
                approvePrimary: true,
                approveSecondary: true,
                approveSupport: true,
                enforceCharacterLimits: true,
                characterLimit: 5,
                autoAvailabilityForPrimary: true,
                autoAvailabilityForSecondary: true,
                autoAvailabilityForSupport: false
            ),
            'discord' => Discord::from([
                'webhook' => null,
                'color' => '#38b2ac',
            ]),
            'posting_activity' => new PostingActivity(
                target: PostingTarget::Words,
                requirement: 250,
                timeframe: PostingTimeframe::Rolling,
                rollingDays: 7
            ),
            'ratings' => new ContentRatings(
                language: new ContentRating(
                    rating: 1,
                    description_0: 'Does not contain profanity',
                    description_1: 'Infrequent, light profanity',
                    description_2: 'Mild profanity',
                    description_3: 'Heavy profanity and mature language',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain heavy profanity and mature language',
                ),
                sex: new ContentRating(
                    rating: 1,
                    description_0: 'Does not contain sexual content',
                    description_1: 'Mild sexual innuendo and references',
                    description_2: 'Sexual content and situations',
                    description_3: 'Explicit sexual content',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain explicit sexual content',
                ),
                violence: new ContentRating(
                    rating: 1,
                    description_0: 'Does not contain violence',
                    description_1: 'Mild violence',
                    description_2: 'Heavy violence',
                    description_3: 'Explicit violence',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain explicit violence',
                ),
            ),
            'applications' => new Applications(
                enabled: true,
                disabledMessage: 'We’re sorry, but applications are currently closed. Please try again at a later date.',
                alwaysShowResults: false,
                allowVoteChanging: false,
                showDecisionMessage: true
            ),
            'writing_dashboard' => new WritingDashboard(
                leaderboard: new Leaderboard(
                    title: 'Posting Contributors',
                    icon: 'tabler-award',
                    target: PostingTarget::Words,
                    userSelectableTimeframe: false,
                    timeframe: LeaderboardTimeframe::Days30,
                    numberOfSpotsToShow: 10,
                    showRankNumbers: false,
                    hideUsersWithZero: true,
                    onlyActiveUsers: true,
                    enabled: true,
                    showPodium: false
                ),
                milestonesTarget: PostingTarget::Words,
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

        activity()->enableLogging();
    }
};
