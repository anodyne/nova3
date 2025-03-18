<?php

declare(strict_types=1);

namespace Nova\Reporting\Repositories;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\StatusHistory;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\Login;
use Nova\Users\Models\User;

class MySQLReportingRepository implements ReportingRepositoryInterface
{
    public function getActivityQuery(?CarbonInterface $start, ?CarbonInterface $end): Builder
    {
        return DB::table('users')
            ->join('status_history', function ($join) {
                $join->on(User::column('id'), '=', StatusHistory::column('statusable_id'))
                    ->where(StatusHistory::column('statusable_type'), '=', 'user');
            })
            ->leftJoin('logins', User::column('id'), '=', Login::column('user_id'))
            ->leftJoin('post_author', User::column('id'), '=', PostAuthor::column('user_id'))
            ->leftJoin('posts', PostAuthor::column('post_id'), '=', Post::column('id'))
            ->leftJoin('post_types', Post::column('post_type_id'), '=', PostType::column('id')) // Include post_types for JSON filtering
            ->where(function ($query) use ($start, $end) {
                $query->where(StatusHistory::column('started_at'), '<=', $end)
                    ->where(function ($query) use ($start) {
                        $query->whereNull(StatusHistory::column('ended_at'))
                            ->orWhere(StatusHistory::column('ended_at'), '>=', $start);
                    });
            })
            ->selectRaw('
                '.User::prefixedColumn('id').',
                '.User::prefixedColumn('name').',
                COUNT(DISTINCT CASE
                    WHEN '.Login::prefixedColumn('created_at').' BETWEEN ? AND ?
                    THEN '.Login::prefixedColumn('id').'
                END) as login_count,
                MAX('.Login::prefixedColumn('created_at').') as latest_login,
                COUNT(DISTINCT CASE
                    WHEN '.Post::prefixedColumn('status').' = "published"
                        AND JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.PostAuthor::prefixedColumn('updated_at').' BETWEEN ? AND ?
                        AND '.Post::prefixedColumn('published_at').' BETWEEN ? AND ?
                    THEN '.Post::prefixedColumn('id').'
                END) as published_post_count,
                COUNT(DISTINCT CASE
                    WHEN '.Post::prefixedColumn('status').' = "draft"
                        AND JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.PostAuthor::prefixedColumn('updated_at').' BETWEEN ? AND ?
                    THEN '.Post::prefixedColumn('id').'
                END) as draft_post_count,
                SUM(CASE
                    WHEN JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.PostAuthor::prefixedColumn('updated_at').' BETWEEN ? AND ?
                    THEN '.PostAuthor::prefixedColumn('word_count').'
                    ELSE 0
                END) as total_word_count
            ', [
                $start, $end,  // For logins.created_at
                $start, $end,  // For post_author.updated_at (published posts)
                $start, $end,  // For posts.published_at
                $start, $end,  // For post_author.updated_at (draft posts)
                $start, $end,  // For post_author.updated_at (word count)
            ])
            ->groupBy(User::column('id'), User::column('name'));
    }

    public function getApplicationStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder {
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
                $endOfTimeframe, $startOfTimeframe, // Timeframe
            ]);
    }

    public function getCharacterStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder {
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

                $endOfTimeframe, $startOfTimeframe, // Timeframe
                $endOfTimeframe, $startOfTimeframe, // Timeframe primary
                $endOfTimeframe, $startOfTimeframe, // Timeframe secondary
                $endOfTimeframe, $startOfTimeframe, // Timeframe support
            ]);
    }

    public function getPostStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder {
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
                $endOfTimeframe, $startOfTimeframe, // Timeframe published

                $endOfLastMonth, $startOfLastMonth, // Last month published words
                $endOfThisMonth, $startOfThisMonth, // This month published words
                $endOfTimeframe, $startOfTimeframe, // Timeframe published words
            ]);
    }

    public function getStoryStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder {
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

                $startOfTimeframe, $endOfTimeframe, // Timeframe completed
                $endOfTimeframe, $startOfTimeframe, // Timeframe current
            ]);
    }

    public function getUserStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder {
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
                $endOfTimeframe, $startOfTimeframe, // Timeframe
            ]);
    }

    public function getParticipantionQuery(?CarbonInterface $start, ?CarbonInterface $end): Builder
    {
        return DB::table('users')
            ->join('status_history', function ($join) {
                $join->on(User::column('id'), '=', StatusHistory::column('statusable_id'))
                    ->where(StatusHistory::column('statusable_type'), '=', 'user');
            })
            ->leftJoin('post_author', User::column('id'), '=', PostAuthor::column('user_id'))
            ->leftJoin('posts', PostAuthor::column('post_id'), '=', Post::column('id'))
            ->leftJoin('post_types', Post::column('post_type_id'), '=', PostType::column('id'))
            ->where(function ($query) use ($start, $end) {
                $query->where(StatusHistory::column('started_at'), '<=', $end)
                    ->where(function ($query) use ($start) {
                        $query->whereNull(StatusHistory::column('ended_at'))
                            ->orWhere(StatusHistory::column('ended_at'), '>=', $start);
                    });
            })
            ->selectRaw('
                '.User::prefixedColumn('id').',
                '.User::prefixedColumn('name').',
                SUM(CASE
                    WHEN JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.PostAuthor::prefixedColumn('updated_at').' BETWEEN ? AND ?
                    THEN '.PostAuthor::prefixedColumn('word_count').'
                    ELSE 0
                END) as total_word_count
            ', [
                $start, $end,  // For post_author.updated_at (word count)
            ])
            ->groupBy(User::column('id'), User::column('name'));
    }

    public function getPostingStatsQuery(CarbonInterface $start, CarbonInterface $end): Builder
    {
        return DB::table('posts')
            ->leftJoin('post_types', Post::column('post_type_id'), '=', PostType::column('id')) // Include post_types for JSON filtering
            ->selectRaw('
                COUNT(DISTINCT CASE
                    WHEN '.Post::prefixedColumn('status').' = "published"
                        AND JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.Post::prefixedColumn('published_at').' BETWEEN ? AND ?
                    THEN '.Post::prefixedColumn('id').'
                END) as published_post_count,
                COUNT(DISTINCT CASE
                    WHEN '.Post::prefixedColumn('status').' = "draft"
                        AND JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.Post::prefixedColumn('updated_at').' BETWEEN ? AND ?
                    THEN '.Post::prefixedColumn('id').'
                END) as draft_post_count,
                SUM(CASE
                    WHEN JSON_EXTRACT('.PostType::prefixedColumn('options').', "$.includedInPostTracking") = true
                        AND '.Post::prefixedColumn('updated_at').' BETWEEN ? AND ?
                    THEN '.Post::prefixedColumn('word_count').'
                    ELSE 0
                END) as total_word_count
            ', [
                $start, $end, // For published_post_count
                $start, $end, // For draft_post_count
                $start, $end, // For total_word_count
            ]);
    }
}
