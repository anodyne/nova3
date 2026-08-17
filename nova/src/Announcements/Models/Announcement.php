<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
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
use Spatie\Activitylog\Models\Activity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $category
 * @property string $content
 * @property PublishStatus $status
 * @property CarbonImmutable|null $published_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $is_published
 * @property-read Collection<int, AnnouncementNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $user
 *
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement draft()
 * @method static \Database\Factories\AnnouncementFactory factory($count = null, $state = [])
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement newModelQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement newQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement pending()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement published()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement query()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement searchFor($search)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement uniqueCategories()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereCategory($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereContent($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereCreatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement wherePrefixedId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement wherePublishedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereStatus($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereTitle($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereUpdatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereUserId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement withReadNotificationsForUser(\Nova\Users\Models\User $user)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement withUnreadNotificationsForUser(\Nova\Users\Models\User $user)
 *
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

    protected $casts = [
        'status' => PublishStatus::class,
        'published_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => AnnouncementCreated::class,
        'deleted' => AnnouncementDeleted::class,
        'updated' => AnnouncementUpdated::class,
    ];

    protected $fillable = [
        'category',
        'content',
        'published_at',
        'status',
        'title',
        'user_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept(['content']);
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->published_at?->lte(Date::now()) ?? false,
        );
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(AnnouncementNotification::class);
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

    public function unreadFor(User $user): bool
    {
        return $this->notifications()
            ->where('user_id', $user->id)
            ->where('is_seen', false)
            ->exists();
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
