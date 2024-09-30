<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Announcements\Events;
use Nova\Announcements\Models\Builders\AnnouncementBuilder;
use Nova\Users\Models\User;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class Announcement extends Model
{
    use HasPrefixedId;

    protected $fillable = [
        'title',
        'content',
        'category',
        'published',
        'published_at',
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

    public function newEloquentBuilder($query): AnnouncementBuilder
    {
        return new AnnouncementBuilder($query);
    }
}
