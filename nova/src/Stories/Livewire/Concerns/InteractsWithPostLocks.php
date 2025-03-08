<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Stories\Actions\LockPost;
use Nova\Stories\Actions\UnlockPost;

trait InteractsWithPostLocks
{
    public function checkLock(): void
    {
        if ($this->post->isLocked() && $this->lastUpdate->gte($this->post->locked_at)) {
            LockPost::run($this->post, Auth::user());
        } else {
            UnlockPost::run($this->post, Auth::user());

            $this->redirectRoute('admin.writing-overview');
        }
    }

    #[Computed]
    public function editableByCurrentUser(): bool
    {
        return ! $this->post->isLocked() || ($this->post->isLocked() && $this->post->lockIsOwnedBy(Auth::user()));
    }

    #[Computed]
    public function postIsLocked(): bool
    {
        return $this->post->isLocked() && ! $this->post->lockIsOwnedBy(Auth::user());
    }

    private function lockPost(): void
    {
        // Only lock a post if there's more than 1 user participating.
        if ($this->editableByCurrentUser && $this->post->participatingUsers->count() > 1) {
            LockPost::run($this->post, Auth::user());
        }
    }
}
