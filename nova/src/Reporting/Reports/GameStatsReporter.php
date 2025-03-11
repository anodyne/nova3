<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\StatusHistory;
use Nova\Reporting\Data\GameStatCategory;
use Nova\Reporting\Data\GameStatLine;
use Nova\Reporting\Data\GameStats;
use Nova\Settings\Data\PostingActivity;
use Nova\Users\Models\User;

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

    public static function make(): static
    {
        return new self;
    }

    protected function applicationQuery()
    {
        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('applications')
            ->selectRaw('
                COUNT(*) as lifetime_count,
                COUNT(DISTINCT CASE
                    WHEN created_at <= ? AND created_at >= ?
                    THEN id END
                ) as last_month_count,
                COUNT(DISTINCT CASE
                    WHEN created_at <= ? AND created_at >= ?
                    THEN id END
                ) as this_month_count,
                COUNT(DISTINCT CASE
                    WHEN created_at <= ? AND created_at >= ?
                    THEN id END
                ) as timeframe_count
            ', [
                $endOfLastMonth, $startOfLastMonth, // Last month
                $endOfThisMonth, $startOfThisMonth, // This month
                $this->postingActivitySettings->timeframe->endDate(), $this->postingActivitySettings->timeframe->startDate(), // Timeframe
            ])
            ->first();
    }

    protected function characterQuery()
    {
        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('characters')
            ->join('status_history', function ($join) {
                $join->on(Character::column('id'), '=', StatusHistory::column('statusable_id'))
                    ->where(StatusHistory::column('statusable_type'), '=', 'character');
            })
            ->selectRaw('
                COUNT(*) as lifetime_count,
                COUNT(DISTINCT CASE
                    WHEN '.Character::prefixedColumn('type').' = "primary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as lifetime_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.Character::prefixedColumn('type').' = "secondary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as lifetime_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.Character::prefixedColumn('type').' = "support"
                    THEN '.Character::prefixedColumn('id').' END
                ) as lifetime_support_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?)
                    THEN '.Character::prefixedColumn('id').' END
                ) as last_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "primary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as last_month_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "secondary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as last_month_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "support"
                    THEN '.Character::prefixedColumn('id').' END
                ) as last_month_support_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?)
                    THEN '.Character::prefixedColumn('id').' END
                ) as this_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "primary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as this_month_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "secondary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as this_month_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "support"
                    THEN '.Character::prefixedColumn('id').' END
                ) as this_month_support_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?)
                    THEN '.Character::prefixedColumn('id').' END
                ) as timeframe_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "primary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as timeframe_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "secondary"
                    THEN '.Character::prefixedColumn('id').' END
                ) as timeframe_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?) AND
                        '.Character::prefixedColumn('type').' = "support"
                    THEN '.Character::prefixedColumn('id').' END
                ) as timeframe_support_count
            ', [
                $endOfLastMonth, $startOfLastMonth, // Last month
                $endOfLastMonth, $startOfLastMonth, // Last month primary
                $endOfLastMonth, $startOfLastMonth, // Last month secondary
                $endOfLastMonth, $startOfLastMonth, // Last month support

                $endOfThisMonth, $startOfThisMonth, // This month
                $endOfThisMonth, $startOfThisMonth, // This month primary
                $endOfThisMonth, $startOfThisMonth, // This month secondary
                $endOfThisMonth, $startOfThisMonth, // This month support

                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe
                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe primary
                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe secondary
                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe support
            ])
            ->first();
    }

    protected function postQuery()
    {
        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('posts')
            ->selectRaw('
                COUNT(DISTINCT CASE
                    WHEN published_at IS NOT NULL
                    THEN id END
                ) as lifetime_published_count,
                COUNT(DISTINCT CASE
                    WHEN published_at <= ? AND published_at >= ?
                    THEN id END
                ) as last_month_published_count,
                COUNT(DISTINCT CASE
                    WHEN published_at <= ? AND published_at >= ?
                    THEN id END
                ) as this_month_published_count,
                COUNT(DISTINCT CASE
                    WHEN published_at <= ? AND published_at >= ?
                    THEN id END
                ) as timeframe_published_count,
                COUNT(DISTINCT CASE
                    WHEN published_at IS NULL AND status = "draft"
                    THEN id END
                ) as lifetime_draft_count,
                SUM(CASE
                    WHEN published_at IS NOT NULL
                    THEN word_count ELSE 0 END
                ) as lifetime_published_words_count,
                SUM(CASE
                    WHEN published_at <= ? AND published_at >= ?
                    THEN word_count ELSE 0 END
                ) as last_month_published_words_count,
                SUM(CASE
                    WHEN published_at <= ? AND published_at >= ?
                    THEN word_count ELSE 0 END
                ) as this_month_published_words_count,
                SUM(CASE
                    WHEN published_at <= ? AND published_at >= ?
                    THEN word_count ELSE 0 END
                ) as timeframe_published_words_count
            ', [
                $endOfLastMonth, $startOfLastMonth, // Last month published
                $endOfThisMonth, $startOfThisMonth, // This month published
                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe published

                $endOfLastMonth, $startOfLastMonth, // Last month published words
                $endOfThisMonth, $startOfThisMonth, // This month published words
                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe published words
            ])
            ->first();
    }

    protected function storyQuery()
    {
        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('stories')
            ->selectRaw('
                COUNT(*) as lifetime_count,
                COUNT(DISTINCT CASE
                    WHEN status = "completed"
                    THEN id END
                ) as lifetime_completed_count,
                COUNT(DISTINCT CASE
                    WHEN status = "current"
                    THEN id END
                ) as lifetime_current_count,
                COUNT(DISTINCT CASE
                    WHEN status = "ongoing"
                    THEN id END
                ) as lifetime_ongoing_count,
                COUNT(DISTINCT CASE
                    WHEN status = "upcoming"
                    THEN id END
                ) as lifetime_upcoming_count,
                COUNT(DISTINCT CASE
                    WHEN ended_at >= ? AND ended_at <= ? AND status = "completed"
                    THEN id END
                ) as last_month_completed_count,
                COUNT(DISTINCT CASE
                    WHEN started_at <= ? AND
                        (ended_at IS NULL OR ended_at >= ?) AND status = "current"
                    THEN id END
                ) as last_month_current_count,
                COUNT(DISTINCT CASE
                    WHEN ended_at >= ? AND ended_at <= ? AND status = "completed"
                    THEN id END
                ) as this_month_completed_count,
                COUNT(DISTINCT CASE
                    WHEN started_at <= ? AND
                        (ended_at IS NULL OR ended_at >= ?) AND status = "current"
                    THEN id END
                ) as this_month_current_count,
                COUNT(DISTINCT CASE
                    WHEN ended_at >= ? AND ended_at <= ? AND status = "completed"
                    THEN id END
                ) as timeframe_completed_count,
                COUNT(DISTINCT CASE
                    WHEN started_at <= ? AND
                        (ended_at IS NULL OR ended_at >= ?) AND status = "current"
                    THEN id END
                ) as timeframe_current_count
            ', [
                $startOfLastMonth, $endOfLastMonth, // Last month completed
                $endOfLastMonth, $startOfLastMonth, // Last month current

                $startOfThisMonth, $endOfThisMonth, // This month completed
                $endOfThisMonth, $startOfThisMonth, // This month current

                $settings->timeframe->startDate(), $settings->timeframe->endDate(), // Timeframe completed
                $settings->timeframe->endDate(), $settings->timeframe->startDate(), // Timeframe current
            ])
            ->first();
    }

    protected function userQuery()
    {
        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('users')
            ->join('status_history', function ($join) {
                $join->on(User::column('id'), '=', StatusHistory::column('statusable_id'))
                    ->where(StatusHistory::column('statusable_type'), '=', 'user');
            })
            ->selectRaw('
                COUNT(*) as lifetime_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?)
                    THEN '.User::prefixedColumn('id').' END
                ) as last_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?)
                    THEN '.User::prefixedColumn('id').' END
                ) as this_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.StatusHistory::prefixedColumn('started_at').' <= ? AND
                        ('.StatusHistory::prefixedColumn('ended_at').' IS NULL OR '.StatusHistory::prefixedColumn('ended_at').' >= ?)
                    THEN '.User::prefixedColumn('id').' END
                ) as timeframe_count
            ', [
                $endOfLastMonth, $startOfLastMonth, // Last month
                $endOfThisMonth, $startOfThisMonth, // This month
                $this->postingActivitySettings->timeframe->endDate(), $this->postingActivitySettings->timeframe->startDate(), // Timeframe
            ])
            ->first();
    }

    protected function average(int $numerator, int $denominator): ?string
    {
        if ($denominator > 0) {
            return Number::format($numerator / $denominator, 1);
        }

        return null;
    }
}
