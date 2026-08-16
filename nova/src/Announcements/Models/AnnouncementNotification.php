<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

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
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Nova\Announcements\Models\Announcement $announcement
 * @property-read User|null $user
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification announcement(int $announcementId)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification newModelQuery()
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification newQuery()
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification query()
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification read()
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification unread()
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification user(int $userId)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification whereAnnouncementId($value)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification whereCreatedAt($value)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification whereId($value)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification whereIsSeen($value)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification whereUpdatedAt($value)
 * @method static AnnouncementNotificationBuilder<static>|AnnouncementNotification whereUserId($value)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(AnnouncementNotificationBuilder::class)]
class AnnouncementNotification extends Model
{
    protected $fillable = ['announcement_id', 'is_seen', 'user_id'];

    protected $casts = [
        'is_seen' => 'boolean',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
