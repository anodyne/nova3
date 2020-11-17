<?php

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Nova\Settings\Values\Defaults;
use Nova\Settings\Values\Discord;

class Settings extends Model
{
    protected $table = 'settings';

    protected $attributes = [
        'defaults' => '[]',
    ];

    protected $casts = [
        'general' => 'json',
        'email' => 'json',
        'defaults' => Defaults::class,
        'characters' => 'json',
        'meta_data' => 'json',
        'discord' => Discord::class,
    ];

    protected $fillable = [
        'key', 'general', 'email', 'defaults', 'meta_data', 'characters', 'discord',
    ];

    public function newEloquentBuilder($query): SettingsBuilder
    {
        return new SettingsBuilder($query);
    }
}
