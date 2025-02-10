<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;

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

    public function newEloquentBuilder($query): AnnouncementNotificationBuilder
    {
        return new AnnouncementNotificationBuilder($query);
    }
}
