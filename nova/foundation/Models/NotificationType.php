<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Data\DiscordSettings;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Foundation\Enums\NotificationChannelStatus;
use Nova\Users\Models\User;

class NotificationType extends Model
{
    protected $table = 'notification_types';

    protected $fillable = [
        'name',
        'key',
        'description',
        'audience',
        'database',
        'mail',
        'discord',
    ];

    protected $casts = [
        'audience' => NotificationAudience::class,
        'mail' => NotificationChannelStatus::class,
        'database' => NotificationChannelStatus::class,
        'discord' => NotificationChannelStatus::class,
        'discord_settings' => DiscordSettings::class,
    ];

    public function userNotificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }

    public function preferencesForUser(User $user = null)
    {
        return $this->userNotificationPreferences()->where('user_id', $user?->id)->first();
    }

    public function getDiscordStatusBadgeColorAttribute(): string
    {
        return $this->discord->color();
    }

    public function getMailStatusBadgeColorAttribute(): string
    {
        return $this->mail->color();
    }

    public function getDatabaseStatusBadgeColorAttribute(): string
    {
        return $this->database->color();
    }
}
