<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\DataTransferObjects\DiscordSettings;

class SystemNotification extends Model
{
    protected $table = 'system_notifications';

    protected $fillable = ['name', 'key', 'category', 'email', 'web', 'discord'];

    protected $casts = [
        'email' => 'boolean',
        'web' => 'boolean',
        'discord' => 'boolean',
        'discord_settings' => DiscordSettings::class,
    ];

    public function getDiscordStatusBadgeColorAttribute(): string
    {
        return [
            0 => 'gray',
            1 => 'green',
        ][$this->discord];
    }

    public function getEmailStatusBadgeColorAttribute(): string
    {
        return [
            0 => 'gray',
            1 => 'green',
        ][$this->email];
    }

    public function getWebStatusBadgeColorAttribute(): string
    {
        return [
            0 => 'gray',
            1 => 'green',
        ][$this->web];
    }
}
