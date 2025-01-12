<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Number;
use Nova\Settings\Enums\PostingTarget;
use Nova\Settings\Enums\PostingTimeframe;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class PostingActivity extends Data implements Arrayable
{
    public function __construct(
        #[Enum(PostingTarget::class)]
        public PostingTarget $target,

        public int $requirement,

        #[Enum(PostingTimeframe::class)]
        public PostingTimeframe $timeframe,

        public ?int $rollingDays
    ) {}

    public function getActivityDescription(): string
    {
        if ($this->target === PostingTarget::Posts) {
            return sprintf(
                'Activity is defined as users who have signed in at least once and have a total count of greater than or equal to %s published %s in %s.',
                Number::format($this->requirement),
                str('post')->plural($this->requirement),
                $this->timeframe->getStatsDescription()
            );
        }

        return sprintf(
            'Activity is defined as users who have signed in at least once and have a sum total of post words greater than or equal to %s for %s.',
            Number::format($this->requirement),
            $this->timeframe->getStatsDescription()
        );
    }

    public function getParticipationDescription(): string
    {
        return sprintf(
            'Participation is defined as users who have a sum total of post words greater than 0 for %s.',
            $this->timeframe->getStatsDescription()
        );
    }

    public function isMonthlyTimeframe(): bool
    {
        return $this->timeframe === PostingTimeframe::Monthly;
    }
}
