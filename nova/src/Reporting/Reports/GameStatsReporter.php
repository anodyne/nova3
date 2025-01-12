<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
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

    public static function make(): static
    {
        return new self;
    }

    public function stats(): GameStats
    {
        $users = $this->userQuery();
        $applications = $this->applicationQuery();
        $characters = $this->characterQuery();
        $stories = $this->storyQuery();
        $posts = $this->postQuery();

        return new GameStats(
            users: new GameStatCategory(
                label: 'Users',
                hint: null,
                stats: [
                    new GameStatLine(
                        label: 'Total',
                        currentTimeframe: Number::format($usersTimeframe = (int) $users->timeframe_count),
                        lastMonth: Number::format($usersLastMonth = (int) $users->last_month_count),
                        thisMonth: Number::format($usersThisMonth = (int) $users->this_month_count),
                        lifetime: Number::format($usersLifetime = (int) $users->lifetime_count)
                    ),
                    new GameStatLine(
                        label: 'Applications',
                        currentTimeframe: Number::format((int) $applications->timeframe_count),
                        lastMonth: Number::format((int) $applications->last_month_count),
                        thisMonth: Number::format((int) $applications->this_month_count),
                        lifetime: Number::format((int) $applications->lifetime_count)
                    ),
                ]
            ),
            characters: new GameStatCategory(
                label: 'Characters',
                hint: null,
                stats: [
                    new GameStatLine(
                        label: 'Total',
                        currentTimeframe: Number::format((int) $characters->timeframe_count),
                        lastMonth: Number::format((int) $characters->last_month_count),
                        thisMonth: Number::format((int) $characters->this_month_count),
                        lifetime: Number::format((int) $characters->lifetime_count)
                    ),
                    new GameStatLine(
                        label: 'Primary characters',
                        currentTimeframe: Number::format((int) $characters->timeframe_primary_count),
                        lastMonth: Number::format((int) $characters->last_month_primary_count),
                        thisMonth: Number::format((int) $characters->this_month_primary_count),
                        lifetime: Number::format((int) $characters->lifetime_primary_count)
                    ),
                    new GameStatLine(
                        label: 'Secondary characters',
                        currentTimeframe: Number::format((int) $characters->timeframe_secondary_count),
                        lastMonth: Number::format((int) $characters->last_month_secondary_count),
                        thisMonth: Number::format((int) $characters->this_month_secondary_count),
                        lifetime: Number::format((int) $characters->lifetime_secondary_count)
                    ),
                    new GameStatLine(
                        label: 'Support characters',
                        currentTimeframe: Number::format((int) $characters->timeframe_support_count),
                        lastMonth: Number::format((int) $characters->last_month_support_count),
                        thisMonth: Number::format((int) $characters->this_month_support_count),
                        lifetime: Number::format((int) $characters->lifetime_support_count)
                    ),
                ]
            ),
            stories: new GameStatCategory(
                label: 'Stories',
                hint: 'Due to story status data being mutable, we’re unable to provide accurate historical stats around stories',
                stats: [
                    new GameStatLine(
                        label: 'Total',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_count)
                    ),
                    new GameStatLine(
                        label: 'Completed',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_completed_count)
                    ),
                    new GameStatLine(
                        label: 'Current',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_current_count)
                    ),
                    new GameStatLine(
                        label: 'Ongoing',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_ongoing_count)
                    ),
                    new GameStatLine(
                        label: 'Upcoming',
                        currentTimeframe: null,
                        lastMonth: null,
                        thisMonth: null,
                        lifetime: Number::format((int) $stories->lifetime_upcoming_count)
                    ),
                ]
            ),
            posts: new GameStatCategory(
                label: 'Posts',
                hint: 'Due to draft status data being mutable, we’re unable to provide accurate historical stats around draft posts',
                stats: [
                    new GameStatLine(
                        label: 'Published',
                        currentTimeframe: Number::format($postsPublishedTimeframe = (int) $posts->timeframe_published_count),
                        lastMonth: Number::format($postsPublishedLastMonth = (int) $posts->last_month_published_count),
                        thisMonth: Number::format($postsPublishedThisMonth = (int) $posts->this_month_published_count),
                        lifetime: Number::format($postsPublishedLifetime = (int) $posts->lifetime_published_count)
                    ),
                    new GameStatLine(
                        label: 'Draft',
                        currentTimeframe: Number::format((int) $posts->lifetime_draft_count),
                        lastMonth: null,
                        thisMonth: Number::format((int) $posts->lifetime_draft_count),
                        lifetime: Number::format((int) $posts->lifetime_draft_count)
                    ),
                    new GameStatLine(
                        label: 'Words',
                        currentTimeframe: Number::format($wordsPublishedTimeframe = (int) $posts->timeframe_published_words_count),
                        lastMonth: Number::format($wordsPublishedLastMonth = (int) $posts->last_month_published_words_count),
                        thisMonth: Number::format($wordsPublishedThisMonth = (int) $posts->this_month_published_words_count),
                        lifetime: Number::format($wordsPublishedLifetime = (int) $posts->lifetime_published_words_count)
                    ),
                ]
            ),
            averages: new GameStatCategory(
                label: 'Averages',
                hint: null,
                stats: [
                    new GameStatLine(
                        label: 'Posts / user',
                        currentTimeframe: $this->average($postsPublishedTimeframe, $usersTimeframe),
                        lastMonth: $this->average($postsPublishedLastMonth, $usersLastMonth),
                        thisMonth: $this->average($postsPublishedThisMonth, $usersThisMonth),
                        lifetime: $this->average($postsPublishedLifetime, $usersLifetime)
                    ),
                    new GameStatLine(
                        label: 'Words / user',
                        currentTimeframe: $this->average($wordsPublishedTimeframe, $usersTimeframe),
                        lastMonth: $this->average($wordsPublishedLastMonth, $usersLastMonth),
                        thisMonth: $this->average($wordsPublishedThisMonth, $usersThisMonth),
                        lifetime: $this->average($wordsPublishedLifetime, $usersLifetime)
                    ),
                    new GameStatLine(
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

        return User::query()
            // ->selectRaw('count(*) lifetime_count')
            ->withCount([
                'statusHistories as last_month_count' => function ($query) {
                    $start = now()->subMonth()->startOfMonth();
                    $end = now()->subMonth()->endOfMonth();

                    $query->where('started_at', '<=', $end)
                        ->where(function (Builder $query) use ($start) {
                            $query->whereNull('ended_at')
                                ->orWhere('ended_at', '>=', $start->copy()->endOfDay());
                        });
                },
                'statusHistories as this_month_count' => function ($query) {
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();

                    $query->where('started_at', '<=', $end)
                        ->where(function (Builder $query) use ($start) {
                            $query->whereNull('ended_at')
                                ->orWhere('ended_at', '>=', $start->copy()->endOfDay());
                        });
                },
            ])
            ->first();
    }

    protected function characterQuery()
    {
        $tablePrefix = DB::getTablePrefix();

        $settings = $this->postingActivitySettings;

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('characters')
            ->join('status_history', function ($join) {
                $join->on('characters.id', '=', 'status_history.statusable_id')
                    ->where('status_history.statusable_type', '=', 'character');
            })
            ->selectRaw('
                COUNT(*) as lifetime_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'characters.type = "primary"
                    THEN '.$tablePrefix.'characters.id END
                ) as lifetime_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'characters.type = "secondary"
                    THEN '.$tablePrefix.'characters.id END
                ) as lifetime_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'characters.type = "support"
                    THEN '.$tablePrefix.'characters.id END
                ) as lifetime_support_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?)
                    THEN '.$tablePrefix.'characters.id END
                ) as last_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "primary"
                    THEN '.$tablePrefix.'characters.id END
                ) as last_month_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "secondary"
                    THEN '.$tablePrefix.'characters.id END
                ) as last_month_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "support"
                    THEN '.$tablePrefix.'characters.id END
                ) as last_month_support_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?)
                    THEN '.$tablePrefix.'characters.id END
                ) as this_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "primary"
                    THEN '.$tablePrefix.'characters.id END
                ) as this_month_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "secondary"
                    THEN '.$tablePrefix.'characters.id END
                ) as this_month_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "support"
                    THEN '.$tablePrefix.'characters.id END
                ) as this_month_support_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?)
                    THEN '.$tablePrefix.'characters.id END
                ) as timeframe_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "primary"
                    THEN '.$tablePrefix.'characters.id END
                ) as timeframe_primary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "secondary"
                    THEN '.$tablePrefix.'characters.id END
                ) as timeframe_secondary_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?) AND
                        '.$tablePrefix.'characters.type = "support"
                    THEN '.$tablePrefix.'characters.id END
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
        $tablePrefix = DB::getTablePrefix();

        $startOfLastMonth = Date::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Date::now()->subMonth()->endOfMonth();
        $startOfThisMonth = Date::now()->startOfMonth();
        $endOfThisMonth = Date::now()->endOfMonth();

        return DB::table('users')
            ->join('status_history', function ($join) {
                $join->on('users.id', '=', 'status_history.statusable_id')
                    ->where('status_history.statusable_type', '=', 'user');
            })
            ->selectRaw('
                COUNT(*) as lifetime_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?)
                    THEN '.$tablePrefix.'users.id END
                ) as last_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?)
                    THEN '.$tablePrefix.'users.id END
                ) as this_month_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'status_history.started_at <= ? AND
                        ('.$tablePrefix.'status_history.ended_at IS NULL OR '.$tablePrefix.'status_history.ended_at >= ?)
                    THEN '.$tablePrefix.'users.id END
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
