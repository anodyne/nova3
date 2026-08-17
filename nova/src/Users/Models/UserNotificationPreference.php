<?php

declare(strict_types=1);

namespace Nova\Users\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereDiscord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereDiscordSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereUserId($value)
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
