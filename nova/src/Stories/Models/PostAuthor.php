<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Carbon\CarbonImmutable;
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
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor draft()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor includedInPostTracking()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor newModelQuery()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor newQuery()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor published()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor query()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor timeframe(?\Carbon\CarbonInterface $start = null, ?\Carbon\CarbonInterface $end = null)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor updatedBetween(?\Carbon\CarbonInterface $start = null, ?\Carbon\CarbonInterface $end = null)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereAs($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereAuthorableId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereAuthorableType($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereCreatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor wherePost(\Nova\Stories\Models\Post|int|null $post)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor wherePostId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereUpdatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereUser(\Nova\Users\Models\User|int $user)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereUserId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereWordCount($value)
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
