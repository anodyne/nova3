<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Users\Models\User;

class ManageGlobalReviewers extends Component
{
    public Collection $assigned;

    public ?string $selected = null;

    public function remove(User $user): void
    {
        $this->assigned = $this->assigned->reject(
            fn (User $collectionUser) => $collectionUser->id === $user->id
        );

        $this->dispatch('reviewers-updated', users: $this->assigned->pluck('id')->all());
    }

    public function updatedSelected(User $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
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
            'models' => $this->models,
            'reviewers' => $this->reviewers,
        ]);
    }

    #[Computed]
    public function globalReviewers(): string
    {
        return $this->assigned
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    #[Computed]
    public function models(): Collection
    {
        return User::query()
            ->active()
            ->get();
    }

    #[Computed]
    public function reviewers(): Collection
    {
        return $this->assigned;
    }
}
