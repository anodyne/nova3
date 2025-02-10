<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Stories\Models\Builders\PostAuthorBuilder;
use Nova\Users\Models\User;

class PostAuthor extends MorphPivot
{
    use HasTableHelpers;

    public function character(): BelongsTo
    {
        if ($this->authorable_type === 'character') {
            return $this->belongsTo(Character::class, 'authorable_id');
        }

        return null;
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newEloquentBuilder($query): PostAuthorBuilder
    {
        return new PostAuthorBuilder($query);
    }
}
