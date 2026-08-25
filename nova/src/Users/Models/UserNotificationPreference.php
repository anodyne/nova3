<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;
use Nova\Foundation\Models\NotificationType;

/**
 * @mixin IdeHelperUserNotificationPreference
 */
class UserNotificationPreference extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'database', 'mail', 'discord'];

    /** @return BelongsTo<NotificationType, $this> */
    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
