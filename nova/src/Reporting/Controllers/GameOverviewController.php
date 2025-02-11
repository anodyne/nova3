<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Controllers\Controller;
use Nova\Reporting\Reports\ActivityReporter;
use Nova\Reporting\Reports\ParticipationReporter;
use Nova\Reporting\Responses\GameOverviewResponse;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

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
        $start = settings('posting_activity')->timeframe->startDate();
        $end = settings('posting_activity')->timeframe->endDate();

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
            ])
            ->first();
    }
}
