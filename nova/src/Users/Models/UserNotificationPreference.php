<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;
use Nova\Foundation\Models\NotificationType;

/**
 * @property int $id
 * @property int $notification_type_id
 * @property int $user_id
 * @property int $database
 * @property int $mail
 * @property int $discord
 * @property string|null $discord_settings
 * @property-read NotificationType $notificationType
 * @property-read User|null $user
 *
 * @method static Builder<static>|UserNotificationPreference newModelQuery()
 * @method static Builder<static>|UserNotificationPreference newQuery()
 * @method static Builder<static>|UserNotificationPreference query()
 * @method static Builder<static>|UserNotificationPreference whereDatabase($value)
 * @method static Builder<static>|UserNotificationPreference whereDiscord($value)
 * @method static Builder<static>|UserNotificationPreference whereDiscordSettings($value)
 * @method static Builder<static>|UserNotificationPreference whereId($value)
 * @method static Builder<static>|UserNotificationPreference whereMail($value)
 * @method static Builder<static>|UserNotificationPreference whereNotificationTypeId($value)
 * @method static Builder<static>|UserNotificationPreference whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserNotificationPreference extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'database', 'mail', 'discord'];

    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
