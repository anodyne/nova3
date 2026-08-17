<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;

/**
 * @property int $id
 * @property int $announcement_id
 * @property int $user_id
 * @property bool $is_seen
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Announcement $announcement
 * @property-read User|null $user
 *
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification announcement(int $announcementId)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification newModelQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification newQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification query()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification read()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification unread()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification user(int $userId)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereAnnouncementId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereCreatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereIsSeen($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereUpdatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(AnnouncementNotificationBuilder::class)]
class AnnouncementNotification extends Model
{
    protected $casts = [
        'is_seen' => 'boolean',
    ];

    protected $fillable = ['announcement_id', 'is_seen', 'user_id'];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
