<?php

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Nova\Settings\Models\Casts\DefaultsSettingsCast;
use Nova\Settings\Models\Casts\DiscordSettingsCast;

class Settings extends Model
{
    protected $table = 'settings';

    protected $casts = [
        'general' => 'json',
        'email' => 'json',
        'defaults' => DefaultsSettingsCast::class,
        'characters' => 'json',
        'meta_data' => 'json',
        'discord' => DiscordSettingsCast::class,
    ];

    protected $fillable = [
        'key', 'general', 'email', 'defaults', 'meta_data', 'characters', 'discord',
    ];

    public function newEloquentBuilder($query): SettingsBuilder
    {
        return new SettingsBuilder($query);
    }
}
