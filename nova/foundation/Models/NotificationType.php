<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Data\DiscordSettings;
use Nova\Foundation\Enums\NotificationAudience;
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
        'database_default',
        'mail',
        'mail_default',
        'discord',
        'discord_settings',
    ];

    protected $casts = [
        'audience' => NotificationAudience::class,
        'mail' => 'boolean',
        'mail_default' => 'boolean',
        'database' => 'boolean',
        'database_default' => 'boolean',
        'discord' => 'boolean',
        'discord_settings' => DiscordSettings::class,
    ];

    public function userNotificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class)
            ->whereHas('user', fn (Builder $query): Builder => $query->active());
    }

    public function preferenceForUser(User $user): UserNotificationPreference
    {
        return $this->userNotificationPreferences()->where('user_id', $user->id)->first();
    }
}
