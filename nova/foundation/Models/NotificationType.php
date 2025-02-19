<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Settings\Data\Discord;
use Nova\Users\Models\User;
use Nova\Users\Models\UserNotificationPreference;

class NotificationType extends Model
{
    protected $table = 'notification_types';

    protected $fillable = [
        'name',
        'key',
        'description',
        'notes',
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
        'discord_settings' => Discord::class,
    ];

    public function discordColor(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (filled($this->discord_settings)) {
                    return $this->discord_settings->color;
                }

                if (filled(settings('discord.color'))) {
                    return settings('discord.color');
                }

                return null;
            }
        );
    }

    public function discordWebhook(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (filled($this->discord_settings)) {
                    return $this->discord_settings->webhook;
                }

                if (filled(settings('discord.webhook'))) {
                    return settings('discord.webhook');
                }

                return null;
            }
        );
    }

    public function userNotificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }

    public function preferenceForUser(User $user): UserNotificationPreference
    {
        return $this->userNotificationPreferences()->where('user_id', $user->id)->first();
    }
}
