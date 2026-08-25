<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Nova\Dashboards\Responses\DashboardResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Onboarding\Concerns\GetActiveOnboardingsForCurrentUser;
use Nova\Settings\Enums\PostingTarget;
use Nova\Users\Data\UserPostingReport;
use Nova\Users\Models\User;
use Nova\Users\Reporting\PostingReporter;

class DashboardController extends Controller
{
    use GetActiveOnboardingsForCurrentUser;

    protected User $user;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        $this->user = Auth::user();

        $postingReporter = PostingReporter::make($this->user);

        $lifetime = $postingReporter->lifetime();
        $currentActivityTimeframe = $postingReporter->currentActivityTimeframe();

        $data = (settings('dashboard.milestonesTarget') === PostingTarget::Words)
            ? $this->getDataForWordBasedStats($lifetime)
            : $this->getDataForPostBasedStats($lifetime);

        return DashboardResponse::sendWith([
            ...$data,
            ...$this->getDataForActivity($currentActivityTimeframe),
            ...[
                'lifetime' => $lifetime,
                'currentActivityTimeframe' => $currentActivityTimeframe,
            ],
            'activeOnboardings' => $this->getActiveOnboardingsForCurrentUser(sync: false),
        ]);
    }

    /**
     * @return array{activityPercentage: int, activityStatement: string}
     */
    protected function getDataForActivity(UserPostingReport $report): array
    {
        $settings = settings('posting_activity');

        $activity = $settings->target === PostingTarget::Words
            ? $report->words
            : $report->posts;

        $percentageComplete = $report->percentageComplete();

        return [
            'activityPercentage' => $percentageComplete,
            'activityStatement' => sprintf(
                '%s %s%s in %s',
                Number::format($activity),
                $settings->target->value,
                $percentageComplete < 100
                    ? str(' of ')->append(Number::format($settings->requirement) ?: number_format($settings->requirement))
                    : '',
                $settings->timeframe->getStatsDescription()
            ),
        ];
    }

    /**
     * @return array{
     *      currentPostingMilestone: float|1,
     *      currentPostingMilestoneValue: int,
     *      nextPostingMilestone: int|float,
     *      postingLevelPercentage: int,
     *      postingMilestoneLabel: mixed
     * }
     */
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

    /**
     * @return array{
     *      wordsLifetime: int,
     *      currentPostingMilestone: float|1,
     *      currentPostingMilestoneValue: int,
     *      nextPostingMilestone: int|float,
     *      postingLevelPercentage: int,
     *      postingMilestoneLabel: mixed
     * }
     */
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
}
