<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
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
 * @property int $id
 * @property int $post_id
 * @property string $authorable_type
 * @property int $authorable_id
 * @property int|null $user_id
 * @property string|null $as
 * @property int $word_count
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Model|\Eloquent $authorable
 * @property-read Character|null $character
 * @property-read Post|null $post
 * @property-read User|null $user
 *
 * @method static PostAuthorBuilder<static>|PostAuthor draft()
 * @method static PostAuthorBuilder<static>|PostAuthor includedInPostTracking()
 * @method static PostAuthorBuilder<static>|PostAuthor newModelQuery()
 * @method static PostAuthorBuilder<static>|PostAuthor newQuery()
 * @method static PostAuthorBuilder<static>|PostAuthor published()
 * @method static PostAuthorBuilder<static>|PostAuthor query()
 * @method static PostAuthorBuilder<static>|PostAuthor timeframe(?CarbonInterface $start = null, ?CarbonInterface $end = null)
 * @method static PostAuthorBuilder<static>|PostAuthor updatedBetween(?CarbonInterface $start = null, ?CarbonInterface $end = null)
 * @method static PostAuthorBuilder<static>|PostAuthor whereAs($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereAuthorableId($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereAuthorableType($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereCreatedAt($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereId($value)
 * @method static PostAuthorBuilder<static>|PostAuthor wherePost(Post|int|null $post)
 * @method static PostAuthorBuilder<static>|PostAuthor wherePostId($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereUpdatedAt($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereUser(User|int $user)
 * @method static PostAuthorBuilder<static>|PostAuthor whereUserId($value)
 * @method static PostAuthorBuilder<static>|PostAuthor whereWordCount($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(PostAuthorBuilder::class)]
class PostAuthor extends MorphPivot
{
    use HasTableHelpers;

    protected $table = 'post_author';

    public function authorable(): MorphTo
    {
        return $this->morphTo();
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'authorable_id')
            ->where(PostAuthor::column('authorable_type'), 'character');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
