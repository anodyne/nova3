<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Database\Factories\AnnouncementFactory;
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
 * @mixin IdeHelperAnnouncement
 */
#[UseEloquentBuilder(AnnouncementBuilder::class)]
class Announcement extends Model
{
    /** @use HasFactory<AnnouncementFactory> */
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

    /**
     * @return HasMany<AnnouncementNotification, $this>
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(AnnouncementNotification::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }

    /** @return Attribute<bool, never> */
    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->published_at?->lte(Date::now()) ?? false,
        );
    }

    public function unreadFor(User $user): bool
    {
        return $this->notifications()
            ->where('user_id', $user->id)
            ->where('is_seen', false)
            ->exists();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept(['content']);
    }

    /**
     * @return array{id: int, prefixed_id: ?string, title: string, category: string|null, content: string}
     */
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
