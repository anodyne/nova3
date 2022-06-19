<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

trait HandlesUserAuthors
{
    public ?array $selectedUsers;

    public function mountHandlesUserAuthors()
    {
        $this->setUserPivotData();
    }

    public function selectedUserAuthors(array $authors): void
    {
        $users = User::query()
            ->whereIn('id', $authors)
            ->whereNotIn('id', $this->post->userAuthors->fresh()->map(fn ($author) => $author->id)->all())
            ->get()
            ->mapWithKeys(fn (User $user) => [
                $user->id => [
                    'user_id' => $user->id,
                    'as' => null,
                ]
            ])
            ->all();

        $this->post->userAuthors()->attach($users);

        $this->refreshUserAuthors();

        $this->setUserPivotData();
    }

    public function setUserPivotData(): void
    {
        $this->selectedUsers = $this->post
            ->userAuthors
            ->mapWithKeys(
                fn (User $user) => [
                    $user->id => [
                        'user_id' => $user->pivot->user_id,
                        'as' => $user->pivot->as,
                    ]
                ]
            )
            ->all();
    }

    public function updatedSelectedUsers(): void
    {
        $this->post->userAuthors()->sync($this->selectedUsers);
    }

    public function removeUserAuthor(User $user): void
    {
        $this->post->userAuthors()->detach($user->id);

        $this->refreshUserAuthors();
    }

    protected function refreshUserAuthors(): void
    {
        $this->users = $this->post->refresh()->userAuthors;
    }
}
