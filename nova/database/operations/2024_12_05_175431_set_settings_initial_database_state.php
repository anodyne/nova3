<?php

declare(strict_types=1);

use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Applications;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRating;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Dashboard;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\FontFamilies;
use Nova\Settings\Data\General;
use Nova\Settings\Data\Leaderboard;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Enums\LeaderboardTimeframe;
use Nova\Settings\Enums\PostingTarget;
use Nova\Settings\Enums\PostingTimeframe;
use Nova\Settings\Models\Settings;
use Nova\Setup\Randomize;
use Nova\Stories\Enums\ContentRatingValue;
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
            'general' => General::from(
                gameName: 'USS Nova',
                contactFormEnabled: true,
                contactFormDisabledMessage: 'We’re sorry, but the contact form is currently closed. Please try again at a later date.',
            ),
            'email' => Email::from(
                subjectPrefix: null,
                replyTo: null,
                imagePath: null,
            ),
            'appearance' => Appearance::from(
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
            'characters' => Characters::from(
                approvePrimary: true,
                approveSecondary: true,
                approveSupport: true,
                enforceCharacterLimits: true,
                characterLimit: 5,
                autoAvailabilityForPrimary: true,
                autoAvailabilityForSecondary: true,
                autoAvailabilityForSupport: false
            ),
            'discord' => Discord::from(
                webhook: null,
                color: '#38b2ac',
            ),
            'posting_activity' => PostingActivity::from(
                target: PostingTarget::Words,
                requirement: 250,
                timeframe: PostingTimeframe::Rolling,
                rollingDays: 7
            ),
            'ratings' => ContentRatings::from(
                language: ContentRating::from(
                    rating: ContentRatingValue::Level1,
                    description0: 'Does not contain profanity',
                    description1: 'Infrequent, light profanity',
                    description2: 'Mild profanity',
                    description3: 'Heavy profanity and mature language',
                    warningThreshold: ContentRatingValue::Level2,
                    warningThresholdMessage: 'May contain heavy profanity and mature language',
                ),
                sex: ContentRating::from(
                    rating: ContentRatingValue::Level1,
                    description0: 'Does not contain sexual content',
                    description1: 'Mild sexual innuendo and references',
                    description2: 'Sexual content and situations',
                    description3: 'Explicit sexual content',
                    warningThreshold: ContentRatingValue::Level2,
                    warningThresholdMessage: 'May contain explicit sexual content',
                ),
                violence: ContentRating::from(
                    rating: ContentRatingValue::Level1,
                    description0: 'Does not contain violence',
                    description1: 'Mild violence',
                    description2: 'Heavy violence',
                    description3: 'Explicit violence',
                    warningThreshold: ContentRatingValue::Level2,
                    warningThresholdMessage: 'May contain explicit violence',
                ),
            ),
            'applications' => Applications::from(
                enabled: true,
                disabledMessage: 'We’re sorry, but applications are currently closed. Please try again at a later date.',
                alwaysShowResults: false,
                allowVoteChanging: false,
                showDecisionMessage: true
            ),
            'dashboard' => Dashboard::from(
                leaderboard: Leaderboard::from(
                    title: 'Top Contributors',
                    icon: 'tabler-award',
                    target: PostingTarget::Words,
                    userSelectableTimeframe: false,
                    timeframe: LeaderboardTimeframe::Days30,
                    numberOfSpotsToShow: 5,
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
