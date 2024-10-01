<?php

declare(strict_types=1);

namespace Nova\Announcements\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder;

class AnnouncementNotification extends Model
{
    protected $fillable = ['announcement_id', 'is_seen', 'user_id'];

    public function newEloquentBuilder($query): AnnouncementNotificationBuilder
    {
        return new AnnouncementNotificationBuilder($query);
    }
}
