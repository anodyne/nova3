<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Users\Models\User;

class ManageGlobalReviewers extends Component
{
    public string $search = '';

    public Collection $assigned;

    public function add(User $user): void
    {
        $this->search = '';

        $this->assigned->push($user);
    }

    public function remove(User $user): void
    {
        $this->assigned = $this->assigned->reject(
            fn (User $collectionUser) => $collectionUser->id === $user->id
        );
    }

    #[Computed]
    public function reviewers(): Collection
    {
        return $this->assigned;
    }

    #[Computed]
    public function searchResults(): Collection
    {
        return User::query()
            ->active()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    #[Computed]
    public function globalReviewers(): string
    {
        return $this->assigned
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    public function mount(): void
    {
        $this->assigned = User::query()
            ->active()
            ->whereHas('globalApplicationReviewer')
            ->get();
    }

    public function render()
    {
        return view('pages.settings.livewire.manage-global-reviewers', [
            'globalReviewers' => $this->globalReviewers,
            'searchResults' => $this->searchResults,
            'reviewers' => $this->reviewers,
        ]);
    }
}
