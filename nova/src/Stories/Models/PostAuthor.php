<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class PostAuthor extends MorphPivot
{
    public function character(): BelongsTo
    {
        if ($this->authorable_type === 'character') {
            return $this->belongsTo(Character::class, 'authorable_id');
        }

        return null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePost(Builder $query, $id): Builder
    {
        return $query->where('post_id', $id);
    }
}
