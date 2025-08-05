<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Bag;
use Nova\Foundation\Icons\Icon;
use Nova\Settings\Enums\LeaderboardTimeframe;
use Nova\Settings\Enums\PostingTarget;

/**
 * @method static static from(string $title, Icon $icon, PostingTarget $target, bool $userSelectableTimeframe, LeaderboardTimeframe $timeframe, ?int $numberOfSpotsToShow, bool $showRankNumbers, bool $hideUsersWithZero, bool $onlyActiveUsers, bool $enabled, bool $showPodium)
 */
readonly class Leaderboard extends Bag
{
    public function __construct(
        public string $title,
        public Icon $icon,
        public PostingTarget $target,
        public bool $userSelectableTimeframe,
        public LeaderboardTimeframe $timeframe,
        public ?int $numberOfSpotsToShow,
        public bool $showRankNumbers,
        public bool $hideUsersWithZero,
        public bool $onlyActiveUsers,
        public bool $enabled,
        public bool $showPodium
    ) {}
}
