<?php

declare(strict_types=1);

namespace Nova\Notes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

/**
 * @extends Builder<Note>
 */
class NoteBuilder extends Builder
{
    public function author(User $user): self
    {
        return $this->where('user_id', $user->id);
    }

    public function currentUser(): self
    {
        return $this->where('user_id', Auth::id());
    }

    public function searchFor(string $search): self
    {
        return $this->whereAny(['title', 'content'], 'like', "%{$search}%");
    }
}
