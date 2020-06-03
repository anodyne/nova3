<?php

namespace Nova\Notes\Models\Builders;

use Nova\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;

class NoteBuilder extends Builder
{
    use Filterable;

    public function whereAuthor(User $user)
    {
        return $this->where('user_id', $user->id);
    }
}
