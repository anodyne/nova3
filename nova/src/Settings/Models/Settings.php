<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\General;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Data\SystemDefaults;
use Nova\Settings\Models\Builders\SettingsBuilder;

class Settings extends Model
{
    protected $table = 'settings';

    protected $casts = [
        'general' => General::class,
        'email' => Email::class,
        'system_defaults' => SystemDefaults::class,
        'characters' => Characters::class,
        'meta_tags' => MetaTags::class,
        'discord' => Discord::class,
        'posting_activity' => PostingActivity::class,
    ];

    protected $fillable = [
        'key',
        'general',
        'email',
        'system_defaults',
        'meta_tags',
        'characters',
        'discord',
        'posting_activity',
    ];

    public function newEloquentBuilder($query): SettingsBuilder
    {
        return new SettingsBuilder($query);
    }
}
