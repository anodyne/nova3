<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Settings\Data\Discord;
use Nova\Users\Models\User;
use Nova\Users\Models\UserNotificationPreference;

/**
 * @mixin IdeHelperNotificationType
 */
class NotificationType extends Model
{
    protected $casts = [
        'audience' => NotificationAudience::class,
        'mail' => 'boolean',
        'mail_default' => 'boolean',
        'database' => 'boolean',
        'database_default' => 'boolean',
        'discord' => 'boolean',
        'discord_settings' => Discord::class,
    ];

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

    protected $table = 'notification_types';

    /** @return Attribute<string|null, never> */
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

    /** @return Attribute<string|null, never> */
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

    public function preferenceForUser(User $user): UserNotificationPreference
    {
        return UserNotificationPreference::query()
            ->whereBelongsTo($this, 'notificationType')
            ->whereBelongsTo($user)
            ->firstOrFail();
    }

    /** @return HasMany<UserNotificationPreference, $this> */
    public function userNotificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }
}
