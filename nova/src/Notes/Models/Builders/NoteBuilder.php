<?php

declare(strict_types=1);

namespace Nova\Notes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Users\Models\User;

class NoteBuilder extends Builder
{
    public function searchFor($search): self
    {
        return $this->whereAny(['title', 'content'], 'like', "%{$search}%");
    }

    public function author(User $user): self
    {
        return $this->where('user_id', $user->id);
    }

    public function currentUser(): self
    {
        return $this->where('user_id', Auth::id());
    }
}
