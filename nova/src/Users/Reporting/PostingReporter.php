<?php

declare(strict_types=1);

namespace Nova\Users\Reporting;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Nova\Settings\Data\PostingActivity;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Data\UserPostingReport;
use Nova\Users\Models\User;

class PostingReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct(
        protected User $user
    ) {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public static function make(User $user): static
    {
        return new self($user);
    }

    public function lifetime(): UserPostingReport
    {
        $result = $this->query();

        return new UserPostingReport(
            posts: (int) $result->total_posts,
            words: (int) $result->total_words
        );
    }

    public function currentActivityTimeframe(): UserPostingReport
    {
        $result = $this->query(
            start: $this->postingActivitySettings->timeframe->startDate(),
            end: $this->postingActivitySettings->timeframe->endDate()
        );

        return new UserPostingReport(
            posts: (int) $result->total_posts,
            words: (int) $result->total_words
        );
    }

    protected function query(?CarbonInterface $start = null, ?CarbonInterface $end = null): PostAuthor
    {
        return PostAuthor::query()
            ->selectRaw('COUNT(*) as total_posts, SUM(word_count) as total_words')
            ->whereUser($this->user)
            ->when(filled($start), fn (Builder $query): Builder => $query->where('updated_at', '>=', $start))
            ->when(filled($end), fn (Builder $query): Builder => $query->where('updated_at', '<=', $end))
            ->first();
    }
}
