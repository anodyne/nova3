<?php

declare(strict_types=1);

namespace Nova\Notes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Users\Models\User;

class NoteBuilder extends Builder
{
    use Filterable;

    public function whereAuthor(User $user): Builder
    {
        return $this->where('user_id', $user->id);
    }
}
