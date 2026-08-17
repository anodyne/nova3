<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Bag;
use Illuminate\Support\Number;
use Nova\Foundation\Helpers\TimeHelper;
use Nova\Settings\Enums\PostingTarget;

/**
 * @method static static from(int $posts, int $words)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class UserPostingReport extends Bag
{
    public function __construct(
        public int $posts,
        public int $words
    ) {}

    public function formattedPosts(): string
    {
        return Number::format($this->posts);
    }

    public function formattedWords(): string
    {
        return Number::format($this->words);
    }

    public function hasMetPostsRequirements(): bool
    {
        $settings = settings('posting_activity');

        if ($settings->target === PostingTarget::Posts && $this->posts >= $settings->requirement) {
            return true;
        }

        return false;
    }

    public function hasMetWordsRequirements(): bool
    {
        $settings = settings('posting_activity');

        if ($settings->target === PostingTarget::Words && $this->words >= $settings->requirement) {
            return true;
        }

        return false;
    }

    public function percentageComplete(): int
    {
        $settings = settings('posting_activity');

        $activity = $settings->target === PostingTarget::Words
            ? $this->words
            : $this->posts;

        $activityPercentage = round(($activity / $settings->requirement) * 100, 0);

        return $activityPercentage > 100 ? 100 : (int) $activityPercentage;
    }

    public function readingTime(): string
    {
        return TimeHelper::readingTime($this->words);
    }
}
