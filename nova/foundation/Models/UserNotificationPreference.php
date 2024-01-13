<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Users\Models\User;

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
