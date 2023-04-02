<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Data\DiscordSettings;
use Nova\Foundation\Enums\SystemNotificationType;

class SystemNotification extends Model
{
    protected $table = 'system_notifications';

    protected $fillable = [
        'name',
        'key',
        'description',
        'type',
        'web',
        'email',
        'discord',
    ];

    protected $casts = [
        'type' => SystemNotificationType::class,
        'email' => 'boolean',
        'web' => 'boolean',
        'discord' => 'boolean',
        'discord_settings' => DiscordSettings::class,
    ];

    public function notifiables(): HasMany
    {
        return $this->hasMany(Notifiable::class);
    }

    public function getDiscordStatusBadgeColorAttribute(): string
    {
        return [
            0 => 'gray',
            1 => 'success',
        ][$this->discord];
    }

    public function getEmailStatusBadgeColorAttribute(): string
    {
        return [
            0 => 'gray',
            1 => 'success',
        ][$this->email];
    }

    public function getWebStatusBadgeColorAttribute(): string
    {
        return [
            0 => 'gray',
            1 => 'success',
        ][$this->web];
    }
}
