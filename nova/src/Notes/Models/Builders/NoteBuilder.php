<?php

namespace Nova\Notes\Models\Builders;

use Nova\Users\Models\User;
use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class NoteBuilder extends Builder
{
    use Filterable;

    public function whereAuthor(User $user): Builder
    {
        return $this->where('user_id', $user->id);
    }
}
