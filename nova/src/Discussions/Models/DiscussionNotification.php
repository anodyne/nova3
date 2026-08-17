<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Nova\Discussions\Models\Builders\DiscussionNotificationBuilder;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $discussion_id
 * @property int $discussion_message_id
 * @property int $user_id
 * @property int $is_seen
 * @property int $is_sender
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification discussion(int $discussionId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification newModelQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification newQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification query()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification unread()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification user(int $userId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereCreatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereDeletedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereDiscussionId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereDiscussionMessageId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereIsSeen($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereIsSender($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereUpdatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(DiscussionNotificationBuilder::class)]
class DiscussionNotification extends Model
{
    protected $fillable = [
        'discussion_id',
        'discussion_message_id',
        'is_seen',
        'is_sender',
        'user_id',
    ];
}
