<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Controllers\Controller;
use Nova\Reporting\Reports\ActivityReporter;
use Nova\Reporting\Reports\ParticipationReporter;
use Nova\Reporting\Responses\GameOverviewResponse;

class GameOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $activity = ActivityReporter::make();
        $participation = ParticipationReporter::make();

        return GameOverviewResponse::sendWith([
            'activity' => $activity,
            'participation' => $participation,
            'postingStats' => $this->getPostingStats(),
            'settings' => settings('posting_activity'),
        ]);
    }

    protected function getPostingStats()
    {
        $tablePrefix = DB::getTablePrefix();

        $start = settings('posting_activity')->timeframe->startDate();
        $end = settings('posting_activity')->timeframe->endDate();

        return DB::table('posts')
            ->leftJoin('post_types', 'posts.post_type_id', '=', 'post_types.id') // Include post_types for JSON filtering
            ->selectRaw('
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'posts.status = "published"
                        AND JSON_EXTRACT('.$tablePrefix.'post_types.options, "$.includedInPostTracking") = true
                        AND '.$tablePrefix.'posts.published_at BETWEEN ? AND ?
                    THEN '.$tablePrefix.'posts.id
                END) as published_post_count,
                COUNT(DISTINCT CASE
                    WHEN '.$tablePrefix.'posts.status = "draft"
                        AND JSON_EXTRACT('.$tablePrefix.'post_types.options, "$.includedInPostTracking") = true
                        AND '.$tablePrefix.'posts.updated_at BETWEEN ? AND ?
                    THEN '.$tablePrefix.'posts.id
                END) as draft_post_count,
                SUM(CASE
                    WHEN JSON_EXTRACT('.$tablePrefix.'post_types.options, "$.includedInPostTracking") = true
                        AND '.$tablePrefix.'posts.updated_at BETWEEN ? AND ?
                    THEN '.$tablePrefix.'posts.word_count
                    ELSE 0
                END) as total_word_count
            ', [
                $start, $end, // For published_post_count
                $start, $end, // For draft_post_count
                $start, $end, // For total_word_count
            ])
            ->first();
    }
}
