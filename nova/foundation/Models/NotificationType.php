<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Settings\Data\Discord;
use Nova\Users\Models\User;
use Nova\Users\Models\UserNotificationPreference;

/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string|null $description
 * @property string|null $notes
 * @property NotificationAudience $audience
 * @property bool $database
 * @property bool $database_default
 * @property bool $mail
 * @property bool $mail_default
 * @property bool $discord
 * @property Discord|null $discord_settings
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read string|null $discord_color
 * @property-read string|null $discord_webhook
 * @property-read Collection<int, UserNotificationPreference> $userNotificationPreferences
 * @property-read int|null $user_notification_preferences_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereAudience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDatabaseDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDiscord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDiscordSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereMailDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
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

    public function preferenceForUser(User $user): UserNotificationPreference
    {
        return UserNotificationPreference::query()
            ->whereBelongsTo($this, 'notificationType')
            ->whereBelongsTo($user)
            ->firstOrFail();
    }

    public function userNotificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }
}
