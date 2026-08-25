<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Settings\Data\Leaderboard;
use Nova\Settings\Enums\LeaderboardTimeframe;
use Nova\Settings\Enums\PostingTarget;
use Nova\Users\Models\User;

/**
 * @property-read LeaderboardTimeframe $selectedTimeframe
 * @property-read Collection<int, User>|null $leaderboard
 * @property-read Collection<int, User> $calculateLeaderboardByPosts
 * @property-read Collection<int, User> $calculateLeaderboardByWords
 * @property-read Leaderboard $settings
 */
class PostingLeaderboard extends Component
{
    public string $timeframe;

    #[Computed]
    public function selectedTimeframe(): LeaderboardTimeframe
    {
        return LeaderboardTimeframe::tryFrom($this->timeframe);
    }

    /**
     * @return Collection<int, User>|null
     */
    #[Computed]
    public function leaderboard(): ?Collection
    {
        if (! $this->settings->enabled) {
            return null;
        }

        if ($this->settings->target === PostingTarget::Words) {
            return $this->calculateLeaderboardByWords;
        }

        return $this->calculateLeaderboardByPosts;
    }

    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function calculateLeaderboardByPosts(): Collection
    {
        return User::query()
            ->when(
                $this->settings->onlyActiveUsers === true,
                fn (Builder $query): Builder => $query->active(),
            )
            ->when(
                $this->settings->onlyActiveUsers === false,
                fn (Builder $query): Builder => $query->activeOrInactive(),
            )
            ->when(
                $this->settings->hideUsersWithZero,
                fn (Builder $query): Builder => $query->whereHas('posts')
            )
            ->withCount([
                'posts as author_count' => function (Builder $query): Builder {
                    $timeframe = LeaderboardTimeframe::tryFrom($this->timeframe);

                    return $timeframe->query($query);
                },
            ])
            ->when(
                filled($this->settings->numberOfSpotsToShow) && $this->settings->numberOfSpotsToShow > 0,
                fn (Builder $query): Builder => $query->limit($this->settings->numberOfSpotsToShow)
            )
            ->orderByDesc('author_count')
            ->get();
    }

    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function calculateLeaderboardByWords(): Collection
    {
        return User::query()
            ->when(
                $this->settings->onlyActiveUsers === true,
                fn (Builder $query): Builder => $query->active(),
            )
            ->when(
                $this->settings->onlyActiveUsers === false,
                fn (Builder $query): Builder => $query->activeOrInactive(),
            )
            ->when(
                $this->settings->hideUsersWithZero,
                fn (Builder $query): Builder => $query->whereHas('posts')
            )
            ->withSum([
                'posts as author_count' => function (Builder $query): Builder {
                    $timeframe = LeaderboardTimeframe::tryFrom($this->timeframe);

                    return $timeframe->query($query);
                },
            ], 'post_author.word_count')
            ->when(
                filled($this->settings->numberOfSpotsToShow) && $this->settings->numberOfSpotsToShow > 0,
                fn (Builder $query): Builder => $query->limit($this->settings->numberOfSpotsToShow)
            )
            ->orderByDesc('author_count')
            ->get();
    }

    #[Computed]
    public function settings(): Leaderboard
    {
        return settings('dashboard.leaderboard');
    }

    public function mount(): void
    {
        $this->timeframe = $this->settings->timeframe->value;
    }

    public function render(): Factory|View
    {
        return view('pages.dashboards.livewire.posting-leaderboard', [
            'leaderboard' => $this->leaderboard,
            'settings' => $this->settings,
            'selectedTimeframe' => $this->selectedTimeframe,
        ]);
    }
}
