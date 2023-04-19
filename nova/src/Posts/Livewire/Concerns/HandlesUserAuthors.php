<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Notifications\UserAuthorAddedToPost;
use Nova\Posts\Notifications\UserAuthorRemovedFromPost;
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
                ],
            ])
            ->all();

        $this->post->userAuthors()->attach($users);

        $this->refreshUserAuthors();

        $this->setUserPivotData();

        $this->sendNotificationsToAddedUsers($authors);
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
                    ],
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
        $this->dispatchBrowserEvent('dropdown-close');

        $this->post->userAuthors()->detach($user->id);

        $this->refreshUserAuthors();

        $user->notify(new UserAuthorRemovedFromPost($this->post));
    }

    protected function refreshUserAuthors(): void
    {
        $this->users = $this->post->refresh()->userAuthors;
    }

    protected function sendNotificationsToAddedUsers(array $authors): void
    {
        User::query()
            ->whereIn('id', $authors)
            ->whereNotIn('id', [auth()->id()])
            ->get()
            ->each->notify(new UserAuthorAddedToPost($this->post));
    }
}
