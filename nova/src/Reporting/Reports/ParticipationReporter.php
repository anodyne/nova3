<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Models\StatusHistory;
use Nova\Reporting\Data\ParticipationReport;
use Nova\Settings\Data\PostingActivity;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\User;

class ParticipationReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct()
    {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public function currentActivityTimeframe(): ParticipationReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->startDate(),
                end: $this->postingActivitySettings->timeframe->endDate()
            );
        });

        return ParticipationReport::from(
            active: $result->where('total_word_count', '>', 0)->count(),
            total: $result->count(),
            results: $result
        );
    }

    public function previousActivityTimeframe(): ParticipationReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->previousStartDate(),
                end: $this->postingActivitySettings->timeframe->previousEndDate()
            );
        });

        return ParticipationReport::from(
            active: $result->where('total_word_count', '>', 0)->count(),
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
            ->groupBy(User::column('id'), User::column('name')) // Group by individual users
            ->get();
    }
}
