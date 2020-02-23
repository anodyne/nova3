<?php

namespace Nova\Notes\Models\Builders;

use Nova\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;

class NoteBuilder extends Builder
{
    public function filter(array $filters)
    {
        return $this->when($filters['search'] ?? null, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    public function whereAuthor(User $user)
    {
        return $this->where('user_id', $user->id);
    }
}
