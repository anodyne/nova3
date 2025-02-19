<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Bag;
use Illuminate\Support\Number;
use Nova\Settings\Enums\PostingTarget;
use Nova\Settings\Enums\PostingTimeframe;

/**
 * @method static static from(PostingTarget $target, int $requirement, PostingTimeframe $timeframe, ?int $rollingDays)
 */
readonly class PostingActivity extends Bag
{
    public function __construct(
        public PostingTarget $target,
        public int $requirement,
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
