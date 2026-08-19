<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Stories\Actions\LockPost;
use Nova\Stories\Actions\UnlockPost;

trait InteractsWithPostLocks
{
    #[Computed]
    public function canBeEditedByCurrentUser(): bool
    {
        return ! $this->post->isLocked() || $this->post->lockIsOwnedBy(Auth::user());
    }

    public function checkLock(): void
    {
        if ($this->shouldUsePostLock) {
            if ($this->post->isLocked() && $this->lastUpdate->gte($this->post->locked_at)) {
                LockPost::run($this->post, Auth::user());
            } else {
                UnlockPost::run($this->post, Auth::user());

                $this->redirectRoute('admin.writing-overview');
            }
        }
    }

    #[Computed]
    public function postIsLocked(): bool
    {
        return $this->post->isLocked() && ! $this->post->lockIsOwnedBy(Auth::user());
    }

    #[Computed]
    public function shouldUsePostLock(): bool
    {
        return $this->post->participatingUsers->count() > 1;
    }

    private function lockPost(): void
    {
        // Only lock a post if there's more than 1 user participating.
        if ($this->canBeEditedByCurrentUser && $this->shouldUsePostLock) {
            LockPost::run($this->post, Auth::user());
        }
    }
}
