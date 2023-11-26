<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Nova\Users\Models\User;

trait HandlesUserAuthors
{
    public Collection $users;

    public array $selectedUsers = [];

    public function mountHandlesUserAuthors()
    {
        $this->setUserPivotData();
    }

    public function addUserAuthor(User $user): void
    {
        $this->search = '';

        $this->users->push($user);

        $this->selectedUsers[$user->id] = [
            'user_id' => $user->id,
            'as' => null,
        ];
    }

    public function removeUserAuthor(User $user): void
    {
        $this->dispatch('dropdown-close');

        $this->users = $this->users->reject(
            fn (User $collectionUser) => $collectionUser->id === $user->id
        );

        unset($this->selectedUsers[$user->id]);
    }

    public function setUserPivotData(): void
    {
        $this->selectedUsers = $this->post?->userAuthors
            ->mapWithKeys(
                fn (User $user) => [
                    $user->id => [
                        'user_id' => $user->pivot->user_id,
                        'as' => $user->pivot->as,
                    ],
                ]
            )
            ->all() ?? [];
    }

    #[Computed]
    public function filteredUsers(): Collection
    {
        if ($this->postType?->options?->allowsUserAuthors) {
            return User::query()
                ->active()
                ->whereNotIn('id', array_keys($this->selectedUsers))
                ->when(filled($this->search), fn (Builder $query): Builder => $query->searchForBasic($this->search))
                ->get();
        }

        return Collection::make();
    }
}
