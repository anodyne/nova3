<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Discussions\Models\Builders\DiscussionParticipantBuilder;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Users\Models\User;

/**
 * @property int $id
 * @property int $discussion_id
 * @property int $user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Nova\Discussions\Models\Discussion|null $discussion
 * @property-read User|null $user
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant discussion(int $discussionId)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant newModelQuery()
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant newQuery()
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant query()
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant user(int $userId)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant whereCreatedAt($value)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant whereDeletedAt($value)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant whereDiscussionId($value)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant whereId($value)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant whereUpdatedAt($value)
 * @method static DiscussionParticipantBuilder<static>|DiscussionParticipant whereUserId($value)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(DiscussionParticipantBuilder::class)]
class DiscussionParticipant extends Pivot
{
    use HasTableHelpers;

    protected $fillable = [
        'discussion_id',
        'deleted_at',
    ];

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
