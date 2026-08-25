<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Number;
use Nova\Reporting\Data\GameStatCategory;
use Nova\Reporting\Data\GameStatLine;
use Nova\Reporting\Data\GameStats;
use Nova\Reporting\Repositories\ReportingRepositoryInterface;
use Nova\Settings\Data\PostingActivity;
use stdClass;

class GameStatsReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct()
    {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public function stats(): GameStats
    {
        $users = $this->userQuery();
        $applications = $this->applicationQuery();
        $characters = $this->characterQuery();
        $stories = $this->storyQuery();
        $posts = $this->postQuery();

        return GameStats::from(
            users: GameStatCategory::from(
                label: 'Users',
                hint: null,
                stats: [
                    GameStatLine::from(
                        label: 'Total',
                        currentTimeframe: Number::format($usersTimeframe = (int) $users->timeframe_count),
                        lastMonth: Number::format($usersLastMonth = (int) $users->last_month_count),
                        thisMonth: Number::format($usersThisMonth = (int) $users->this_month_count),
                        lifetime: Number::format($usersLifetime = (int) $users->lifetime_count)
                    ),
                    GameStatLine::from(
                        label: 'Applications',
                        currentTimeframe: Number::format((int) $applications->timeframe_count),
                        lastMonth: Number::format((int) $applications->last_month_count),
                        thisMonth: Number::format((int) $applications->this_month_count),
                        lifetime: Number::format((int) $applications->lifetime_count)
                    ),
                ]
            ),
            characters: GameStatCategory::from(
                label: 'Characters',
                hint: null,
                stats: [
                    GameStatLine::from(
                        label: 'Total',
                        currentTimeframe: Number::format((int) $characters->timeframe_count),
                        lastMonth: Number::format((int) $characters->last_month_count),
                        thisMonth: Number::format((int) $characters->this_month_count),
                        lifetime: Number::format((int) $characters->lifetime_count)
                    ),
                    GameStatLine::from(
                        label: 'Primary characters',
                        currentTimeframe: Number::format((int) $characters->timeframe_primary_count),
                        lastMonth: Number::format((int) $characters->last_month_primary_count),
                        thisMonth: Number::format((int) $characters->this_month_primary_count),
                        lifetime: Number::format((int) $characters->lifetime_primary_count)
                    ),
                    GameStatLine::from(
                        label: 'Secondary characters',
                        currentTimeframe: Number::format((int) $characters->timeframe_secondary_count),
                        lastMonth: Number::format((int) $characters->last_month_secondary_count),
                        thisMonth: Number::format((int) $characters->this_month_secondary_count),
                        lifetime: Number::format((int) $characters->lifetime_secondary_count)
                    ),
                    GameStatLine::from(
                        label: 'Support characters',
                        currentTimeframe: Number::format((int) $characters->timeframe_support_count),
                        lastMonth: Number::format((int) $characters->last_month_support_count),
                        thisMonth: Number::format((int) $characters->this_month_support_count),
                        lifetime: Number::format((int) $characters->lifetime_support_count)
                    ),
                ]
            ),
            stories: GameStatCategory::from(
                label: 'Stories',
                hint: 'Due to story status data being mutable, we’re unable to provide accurate historical stats around stories',
                stats: [
                    GameStatLine::from(
                        label: 'Total',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_count)
                    ),
                    GameStatLine::from(
                        label: 'Completed',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_completed_count)
                    ),
                    GameStatLine::from(
                        label: 'Current',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_current_count)
                    ),
                    GameStatLine::from(
                        label: 'Ongoing',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_ongoing_count)
                    ),
                    GameStatLine::from(
                        label: 'Upcoming',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_upcoming_count)
                    ),
                ]
            ),
            posts: GameStatCategory::from(
                label: 'Posts',
                hint: 'Due to draft status data being mutable, we’re unable to provide accurate historical stats around draft posts',
                stats: [
                    GameStatLine::from(
                        label: 'Published',
                        currentTimeframe: Number::format($postsPublishedTimeframe = (int) $posts->timeframe_published_count),
                        lastMonth: Number::format($postsPublishedLastMonth = (int) $posts->last_month_published_count),
                        thisMonth: Number::format($postsPublishedThisMonth = (int) $posts->this_month_published_count),
                        lifetime: Number::format($postsPublishedLifetime = (int) $posts->lifetime_published_count)
                    ),
                    GameStatLine::from(
                        label: 'Draft',
                        currentTimeframe: Number::format((int) $posts->lifetime_draft_count),
                        lastMonth: null,
                        thisMonth: Number::format((int) $posts->lifetime_draft_count),
                        lifetime: Number::format((int) $posts->lifetime_draft_count)
                    ),
                    GameStatLine::from(
                        label: 'Words',
                        currentTimeframe: Number::format($wordsPublishedTimeframe = (int) $posts->timeframe_published_words_count),
                        lastMonth: Number::format($wordsPublishedLastMonth = (int) $posts->last_month_published_words_count),
                        thisMonth: Number::format($wordsPublishedThisMonth = (int) $posts->this_month_published_words_count),
                        lifetime: Number::format($wordsPublishedLifetime = (int) $posts->lifetime_published_words_count)
                    ),
                ]
            ),
            averages: GameStatCategory::from(
                label: 'Averages',
                hint: null,
                stats: [
                    GameStatLine::from(
                        label: 'Posts / user',
                        currentTimeframe: $this->average($postsPublishedTimeframe, $usersTimeframe),
                        lastMonth: $this->average($postsPublishedLastMonth, $usersLastMonth),
                        thisMonth: $this->average($postsPublishedThisMonth, $usersThisMonth),
                        lifetime: $this->average($postsPublishedLifetime, $usersLifetime)
                    ),
                    GameStatLine::from(
                        label: 'Words / user',
                        currentTimeframe: $this->average($wordsPublishedTimeframe, $usersTimeframe),
                        lastMonth: $this->average($wordsPublishedLastMonth, $usersLastMonth),
                        thisMonth: $this->average($wordsPublishedThisMonth, $usersThisMonth),
                        lifetime: $this->average($wordsPublishedLifetime, $usersLifetime)
                    ),
                    GameStatLine::from(
                        label: 'Words / post',
                        currentTimeframe: $this->average($wordsPublishedTimeframe, $postsPublishedTimeframe),
                        lastMonth: $this->average($wordsPublishedLastMonth, $postsPublishedLastMonth),
                        thisMonth: $this->average($wordsPublishedThisMonth, $postsPublishedThisMonth),
                        lifetime: $this->average($wordsPublishedLifetime, $postsPublishedLifetime)
                    ),
                ]
            ),
        );
    }

    public static function make(): self
    {
        return new self;
    }

    protected function applicationQuery(): stdClass
    {
        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return app(ReportingRepositoryInterface::class)
            ->getApplicationStatsQuery(
                startOfLastMonth: $startOfLastMonth,
                endOfLastMonth: $endOfLastMonth,
                startOfThisMonth: $startOfThisMonth,
                endOfThisMonth: $endOfThisMonth,
                startOfTimeframe: $this->postingActivitySettings->timeframe->startDate(),
                endOfTimeframe: $this->postingActivitySettings->timeframe->endDate(),
            )
            ->firstOrFail();
    }

    protected function average(int $numerator, int $denominator): ?string
    {
        if ($denominator > 0) {
            return Number::format($numerator / $denominator, 1);
        }

        return null;
    }

    protected function characterQuery(): stdClass
    {
        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return app(ReportingRepositoryInterface::class)
            ->getCharacterStatsQuery(
                startOfLastMonth: $startOfLastMonth,
                endOfLastMonth: $endOfLastMonth,
                startOfThisMonth: $startOfThisMonth,
                endOfThisMonth: $endOfThisMonth,
                startOfTimeframe: $settings->timeframe->startDate(),
                endOfTimeframe: $settings->timeframe->endDate()
            )
            ->firstOrFail();
    }

    protected function postQuery(): stdClass
    {
        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return app(ReportingRepositoryInterface::class)
            ->getPostStatsQuery(
                startOfLastMonth: $startOfLastMonth,
                endOfLastMonth: $endOfLastMonth,
                startOfThisMonth: $startOfThisMonth,
                endOfThisMonth: $endOfThisMonth,
                startOfTimeframe: $settings->timeframe->startDate(),
                endOfTimeframe: $settings->timeframe->endDate()
            )
            ->firstOrFail();
    }

    protected function storyQuery(): stdClass
    {
        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return app(ReportingRepositoryInterface::class)
            ->getStoryStatsQuery(
                startOfLastMonth: $startOfLastMonth,
                endOfLastMonth: $endOfLastMonth,
                startOfThisMonth: $startOfThisMonth,
                endOfThisMonth: $endOfThisMonth,
                startOfTimeframe: $settings->timeframe->startDate(),
                endOfTimeframe: $settings->timeframe->endDate()
            )
            ->firstOrFail();
    }

    protected function userQuery(): stdClass
    {
        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return app(ReportingRepositoryInterface::class)
            ->getUserStatsQuery(
                startOfLastMonth: $startOfLastMonth,
                endOfLastMonth: $endOfLastMonth,
                startOfThisMonth: $startOfThisMonth,
                endOfThisMonth: $endOfThisMonth,
                startOfTimeframe: $this->postingActivitySettings->timeframe->startDate(),
                endOfTimeframe: $this->postingActivitySettings->timeframe->endDate()
            )
            ->firstOrFail();
    }
}
