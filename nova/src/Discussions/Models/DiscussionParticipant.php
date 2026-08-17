<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Carbon\CarbonImmutable;
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
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read Discussion|null $discussion
 * @property-read User|null $user
 *
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant discussion(int $discussionId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant newModelQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant newQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant query()
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant user(int $userId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereCreatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereDeletedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereDiscussionId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereUpdatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereUserId($value)
 *
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
