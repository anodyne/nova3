<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Nova\Settings\Values\Characters;
use Nova\Settings\Values\Defaults;
use Nova\Settings\Values\Discord;
use Nova\Settings\Values\Email;
use Nova\Settings\Values\General;

class Settings extends Model
{
    protected $table = 'settings';

    protected $attributes = [
        'defaults' => '[]',
    ];

    protected $casts = [
        'general' => General::class,
        'email' => Email::class,
        'defaults' => Defaults::class,
        'characters' => Characters::class,
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
