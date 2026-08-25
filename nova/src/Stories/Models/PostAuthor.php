<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Stories\Models\Builders\PostAuthorBuilder;
use Nova\Users\Models\User;

/**
 * @mixin IdeHelperPostAuthor
 */
#[UseEloquentBuilder(PostAuthorBuilder::class)]
class PostAuthor extends MorphPivot
{
    use HasTableHelpers;

    protected $table = 'post_author';

    /** @return MorphTo<Model, $this> */
    public function authorable(): MorphTo
    {
        return $this->morphTo();
    }

    /** @return BelongsTo<Character, $this> */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'authorable_id')
            ->where(PostAuthor::column('authorable_type'), 'character');
    }

    /** @return BelongsTo<Post, $this> */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
