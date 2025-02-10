<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Nova\Announcements\Events;
use Nova\Announcements\Models\Builders\AnnouncementBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

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
        'published',
        'title',
        'user_id',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => Events\AnnouncementCreated::class,
        'deleted' => Events\AnnouncementDeleted::class,
        'updated' => Events\AnnouncementUpdated::class,
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

    public function newEloquentBuilder($query): AnnouncementBuilder
    {
        return new AnnouncementBuilder($query);
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
