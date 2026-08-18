<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Nova\Reporting\Data\PostTypeReport;
use Nova\Settings\Data\PostingActivity;
use Nova\Stories\Models\Builders\PostBuilder;
use Nova\Stories\Models\PostType;

class PostTypeReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct()
    {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public function currentActivityTimeframe(): PostTypeReport
    {
        $result = $this->query(
            start: $this->postingActivitySettings->timeframe->startDate(),
            end: $this->postingActivitySettings->timeframe->endDate()
        );

        return PostTypeReport::from(
            results: $result
        );
    }

    public function previousActivityTimeframe(): PostTypeReport
    {
        $result = $this->query(
            start: $this->postingActivitySettings->timeframe->previousStartDate(),
            end: $this->postingActivitySettings->timeframe->previousEndDate()
        );

        return PostTypeReport::from(
            results: $result
        );
    }

    public static function make(): self
    {
        return new self;
    }

    protected function query(?CarbonInterface $start = null, ?CarbonInterface $end = null): Collection
    {
        return PostType::query()
            ->withCount([
                'posts as published_posts_count' => function (PostBuilder $query) use ($start, $end): PostBuilder {
                    return $query
                        ->whereBetween('published_at', [$start, $end])
                        ->published();
                },
                'posts as draft_posts_count' => function (PostBuilder $query) use ($start, $end): PostBuilder {
                    return $query
                        ->whereBetween('updated_at', [$start, $end])
                        ->draft();
                },
            ])
            ->withSum(['posts as published_posts_sum_word_count' => function (PostBuilder $query) use ($start, $end): PostBuilder {
                return $query->whereBetween('updated_at', [$start, $end]);
            }], 'word_count')
            ->get();
    }
}
