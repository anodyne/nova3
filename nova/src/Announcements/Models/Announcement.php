<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;
use Laravel\Scout\Searchable;
use Nova\Announcements\Events\AnnouncementCreated;
use Nova\Announcements\Events\AnnouncementDeleted;
use Nova\Announcements\Events\AnnouncementUpdated;
use Nova\Announcements\Models\Builders\AnnouncementBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $category
 * @property string $content
 * @property PublishStatus $status
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $is_published
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Announcements\Models\AnnouncementNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $user
 * @method static AnnouncementBuilder<static>|Announcement draft()
 * @method static \Database\Factories\AnnouncementFactory factory($count = null, $state = [])
 * @method static AnnouncementBuilder<static>|Announcement newModelQuery()
 * @method static AnnouncementBuilder<static>|Announcement newQuery()
 * @method static AnnouncementBuilder<static>|Announcement pending()
 * @method static AnnouncementBuilder<static>|Announcement published()
 * @method static AnnouncementBuilder<static>|Announcement query()
 * @method static AnnouncementBuilder<static>|Announcement searchFor($search)
 * @method static AnnouncementBuilder<static>|Announcement uniqueCategories()
 * @method static AnnouncementBuilder<static>|Announcement whereCategory($value)
 * @method static AnnouncementBuilder<static>|Announcement whereContent($value)
 * @method static AnnouncementBuilder<static>|Announcement whereCreatedAt($value)
 * @method static AnnouncementBuilder<static>|Announcement whereId($value)
 * @method static AnnouncementBuilder<static>|Announcement wherePrefixedId($value)
 * @method static AnnouncementBuilder<static>|Announcement wherePublishedAt($value)
 * @method static AnnouncementBuilder<static>|Announcement whereStatus($value)
 * @method static AnnouncementBuilder<static>|Announcement whereTitle($value)
 * @method static AnnouncementBuilder<static>|Announcement whereUpdatedAt($value)
 * @method static AnnouncementBuilder<static>|Announcement whereUserId($value)
 * @method static AnnouncementBuilder<static>|Announcement withReadNotificationsForUser(\Nova\Users\Models\User $user)
 * @method static AnnouncementBuilder<static>|Announcement withUnreadNotificationsForUser(\Nova\Users\Models\User $user)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(AnnouncementBuilder::class)]
class Announcement extends Model
{
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }
    use Searchable;

    protected $fillable = [
        'category',
        'content',
        'published_at',
        'status',
        'title',
        'user_id',
    ];

    protected $casts = [
        'status' => PublishStatus::class,
        'published_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => AnnouncementCreated::class,
        'deleted' => AnnouncementDeleted::class,
        'updated' => AnnouncementUpdated::class,
    ];

    public function notifications(): HasMany
    {
        return $this->hasMany(AnnouncementNotification::class);
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->published_at?->lte(Date::now()) ?? false,
        );
    }

    public function unreadFor(User $user): bool
    {
        return $this->notifications()->user($user->id)->unread()->count() > 0;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept(['content']);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'prefixed_id' => $this->prefixed_id,
            'title' => $this->title,
            'category' => $this->category,
            'content' => $this->content,
        ];
    }
}
