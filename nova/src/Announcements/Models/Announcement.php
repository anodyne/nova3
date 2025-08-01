<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Nova\Announcements\Events\AnnouncementCreated;
use Nova\Announcements\Events\AnnouncementDeleted;
use Nova\Announcements\Events\AnnouncementUpdated;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Nova\Announcements\Events;
use Nova\Announcements\Models\Builders\AnnouncementBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

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
        return $this->belongsTo(User::class);
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
