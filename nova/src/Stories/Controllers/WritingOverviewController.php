<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Enums\PostingTarget;
use Nova\Stories\Models\Post;
use Nova\Stories\Responses\WritingOverviewResponse;
use Nova\Users\Data\UserPostingReport;
use Nova\Users\Models\User;
use Nova\Users\Reporting\PostingReporter;

class WritingOverviewController extends Controller
{
    protected User $user;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $this->user = Auth::user();

        $reporter = PostingReporter::make($this->user);

        $lifetime = $reporter->lifetime();
        $currentActivityTimeframe = $reporter->currentActivityTimeframe();

        $data = (settings('writing_dashboard.milestonesTarget') === PostingTarget::Words)
            ? $this->getDataForWordBasedStats($lifetime)
            : $this->getDataForPostBasedStats($lifetime);

        return WritingOverviewResponse::sendWith([
            ...$data,
            ...$this->getDataForActivity($currentActivityTimeframe),
            ...[
                'lifetime' => $lifetime,
                'currentActivityTimeframe' => $currentActivityTimeframe,
                'drafts' => $this->getDraftPosts(),
            ],
        ]);
    }

    protected function getDataForActivity(UserPostingReport $report): array
    {
        $settings = settings('posting_activity');

        $activity = $settings->target === PostingTarget::Words
            ? $report->words
            : $report->posts;

        return [
            'activityInTimeframe' => Number::format($activity ?? 0),
            'activityTarget' => Number::format($settings->requirement),
            'activityPercentage' => $report->percentageComplete(),
            'activityLabel' => sprintf(
                '%s %s goal',
                $settings->timeframe->getActivityLabel(),
                $settings->target->value
            ),
        ];
    }

    protected function getDataForPostBasedStats(UserPostingReport $report): array
    {
        $postingMilestoneIncrement = 100;

        $currentPostingMilestone = ceil($report->posts / $postingMilestoneIncrement);
        $currentPostingMilestone = $currentPostingMilestone > 0 ? $currentPostingMilestone : 1;

        $nextPostingMilestone = $currentPostingMilestone * $postingMilestoneIncrement;

        $postingLevelPercentage = (int) round(($report->posts / $nextPostingMilestone) * 100, 0);

        return [
            'currentPostingMilestone' => $currentPostingMilestone,
            'currentPostingMilestoneValue' => $report->posts,
            'nextPostingMilestone' => $nextPostingMilestone,
            'postingLevelPercentage' => $postingLevelPercentage,
            'postingMilestoneLabel' => str('post')->plural($report->posts),
        ];
    }

    protected function getDataForWordBasedStats(UserPostingReport $report): array
    {
        $postingMilestoneIncrement = 10_000;

        $currentPostingMilestone = ceil($report->words / $postingMilestoneIncrement);
        $currentPostingMilestone = $currentPostingMilestone > 0 ? $currentPostingMilestone : 1;

        $nextPostingMilestone = $currentPostingMilestone * $postingMilestoneIncrement;

        $postingLevelPercentage = (int) round(($report->words / $nextPostingMilestone) * 100, 0);

        return [
            'wordsLifetime' => $report->words,
            'currentPostingMilestone' => $currentPostingMilestone,
            'currentPostingMilestoneValue' => $report->words,
            'nextPostingMilestone' => $nextPostingMilestone,
            'postingLevelPercentage' => $postingLevelPercentage,
            'postingMilestoneLabel' => str('word')->plural($report->words),
        ];
    }

    protected function getDraftPosts(): Collection
    {
        return Post::with('postType', 'story')
            ->draft()
            ->whereHas('story', fn (Builder $query): Builder => $query->current())
            ->whereHas(
                'participatingUsers',
                fn (Builder $query): Builder => $query->where('post_author.user_id', $this->user->id)
            )
            ->get();
    }
}
