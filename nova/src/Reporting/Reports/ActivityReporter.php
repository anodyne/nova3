<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Models\StatusHistory;
use Nova\Reporting\Data\ActivityReport;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Enums\PostingTarget;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\Login;
use Nova\Users\Models\User;

class ActivityReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct()
    {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public function currentActivityTimeframe(): ActivityReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->startDate(),
                end: $this->postingActivitySettings->timeframe->endDate()
            );
        });

        return ActivityReport::from(
            active: $this->calculateActive($result),
            total: $result->count(),
            results: $result
        );
    }

    public function previousActivityTimeframe(): ActivityReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->previousStartDate(),
                end: $this->postingActivitySettings->timeframe->previousEndDate()
            );
        });

        return ActivityReport::from(
            active: $this->calculateActive($result),
            total: $result->count(),
            results: null
        );
    }

    public function percentageChange(): int
    {
        $previous = $this->previousActivityTimeframe()->percentage();
        $current = $this->currentActivityTimeframe()->percentage();

        if ($previous === 0 && $current > 0) {
            return 100;
        }

        if ($previous === 0 && $current === 0) {
            return 0;
        }

        $diff = (($current - $previous) / $previous) * 100;

        return intval(round($diff, 0));
    }

    public function percentageChangeBadge(): string
    {
        $change = $this->percentageChange();

        return match (true) {
            $change > 0 => Blade::render('<x-badge color="success">&uarr; '.$change.'%</x-badge>'),
            $change < 0 => Blade::render('<x-badge color="danger">&darr; '.abs($change).'%</x-badge>'),
            default => '',
        };
    }

    public static function make(): static
    {
        return new self;
    }

    protected function query(?CarbonInterface $start = null, ?CarbonInterface $end = null): Collection
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
            ->groupBy(User::column('id'), User::column('name')) // Group by individual users
            ->get()
            ->map(function ($user) {
                // Convert `latest_login` to Carbon, handling null values
                $user->latest_login = $user->latest_login ? Date::parse($user->latest_login) : null;

                return $user;
            });
    }

    protected function calculateActive(Collection $result): int
    {
        $settings = settings('posting_activity');

        return $result
            ->where('login_count', '>', 0)
            ->when(
                $settings->target === PostingTarget::Posts,
                fn (Collection $collection): Collection => $collection->where('published_post_count', '>=', $settings->requirement)
            )
            ->when(
                $settings->target === PostingTarget::Words,
                fn (Collection $collection): Collection => $collection->where('total_word_count', '>=', $settings->requirement)
            )
            ->count();
    }
}
