<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Nova\Foundation\Rules\Boolean;
use Nova\Settings\Enums\LeaderboardTimeframe;
use Nova\Settings\Enums\PostingTarget;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class Leaderboard extends Data implements Arrayable
{
    public function __construct(
        public string $title,
        public string $icon,

        #[Enum(PostingTarget::class)]
        public PostingTarget $target,

        public bool $userSelectableTimeframe,

        #[Enum(LeaderboardTimeframe::class)]
        public LeaderboardTimeframe $timeframe,

        public ?int $numberOfSpotsToShow,
        public bool $showRankNumbers,
        public bool $hideUsersWithZero,
        public bool $onlyActiveUsers,
        public bool $enabled,
        public bool $showPodium
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'enabled' => new Boolean,
            'userSelectableTimeframe' => new Boolean,
            'showRankNumbers' => new Boolean,
            'hideUsersWithZero' => new Boolean,
            'onlyActiveUsers' => new Boolean,
            'showPodium' => new Boolean,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            title: data_get($data, 'title'),
            icon: data_get($data, 'icon'),
            target: PostingTarget::tryFrom(data_get($data, 'target', 'words')),
            userSelectableTimeframe: Arr::boolean($data, 'userSelectableTimeframe'),
            timeframe: LeaderboardTimeframe::tryFrom(data_get($data, 'timeframe', '30-days')),
            numberOfSpotsToShow: (int) data_get($data, 'numberOfSpotsToShow'),
            showRankNumbers: Arr::boolean($data, 'showRankNumbers'),
            hideUsersWithZero: Arr::boolean($data, 'hideUsersWithZero'),
            onlyActiveUsers: Arr::boolean($data, 'onlyActiveUsers'),
            enabled: Arr::boolean($data, 'enabled'),
            showPodium: Arr::boolean($data, 'showPodium'),
        );
    }
}
