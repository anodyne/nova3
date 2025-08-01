<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Nova\Settings\Data\General;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Applications;
use Nova\Settings\Data\Dashboard;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Nova\Foundation\Models\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Settings\Data;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Spatie\MediaLibrary\HasMedia;

#[UseEloquentBuilder(SettingsBuilder::class)]
class Settings extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'settings';

    protected $casts = [
        'general' => General::class,
        'email' => Email::class,
        'appearance' => Appearance::class,
        'characters' => Characters::class,
        'discord' => Discord::class,
        'posting_activity' => PostingActivity::class,
        'ratings' => ContentRatings::class,
        'applications' => Applications::class,
        'dashboard' => Dashboard::class,
    ];

    protected $fillable = [
        'key',
        'general',
        'email',
        'appearance',
        'meta_tags',
        'characters',
        'discord',
        'posting_activity',
        'ratings',
        'applications',
        'dashboard',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-settings');

        $this->addMediaCollection('email-logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-settings');
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
