<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Notes\Models\Note;

trait HasNotes
{
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
