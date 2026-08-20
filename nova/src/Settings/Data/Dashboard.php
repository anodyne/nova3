<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Anodyne\TablerIcons\Tabler;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Settings\Enums\LeaderboardTimeframe;
use Nova\Settings\Enums\PostingTarget;

/**
 * @method static static from(Leaderboard $leaderboard, PostingTarget $milestonesTarget)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class Dashboard extends Bag
{
    public function __construct(
        public Leaderboard $leaderboard,
        public PostingTarget $milestonesTarget
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'leaderboard' => Leaderboard::from(
                title: $request->input('leaderboard.title'),
                icon: Tabler::tryFrom($request->input('leaderboard.icon')) ?? null,
                target: PostingTarget::tryFrom($request->input('leaderboard.target')) ?? PostingTarget::Words,
                userSelectableTimeframe: $request->boolean('leaderboard.userSelectableTimeframe', false),
                timeframe: LeaderboardTimeframe::tryFrom($request->input('leaderboard.timeframe')) ?? LeaderboardTimeframe::Days7,
                numberOfSpotsToShow: $request->filled('leaderboard.numberOfSpotsToShow')
                    ? $request->integer('leaderboard.numberOfSpotsToShow')
                    : null,
                showRankNumbers: $request->boolean('leaderboard.showRankNumbers', false),
                hideUsersWithZero: $request->boolean('leaderboard.hideUsersWithZero', true),
                onlyActiveUsers: $request->boolean('leaderboard.onlyActiveUsers', true),
                enabled: $request->boolean('leaderboard.enabled', true),
                showPodium: $request->boolean('leaderboard.showPodium', false),
            ),
            'milestonesTarget' => PostingTarget::tryFrom($request->input('milestonesTarget')) ?? PostingTarget::Words,
        ];
    }
}
