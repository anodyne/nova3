<?php

declare(strict_types=1);

namespace Nova\Notes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Users\Models\User;

class NoteBuilder extends Builder
{
    public function searchFor($search): self
    {
        return $this->where(
            fn ($query) => $query->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%")
        );
    }

    public function author(User $user): self
    {
        return $this->where('user_id', $user->id);
    }

    public function currentUser(): self
    {
        return $this->where('user_id', auth()->id());
    }
}
