<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Nova\Foundation\Models\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Applications;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Dashboard;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\General;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Spatie\MediaLibrary\HasMedia;

/**
 * @mixin IdeHelperSettings
 */
#[UseEloquentBuilder(SettingsBuilder::class)]
class Settings extends Model implements HasMedia
{
    use InteractsWithMedia;

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

    protected $table = 'settings';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo-full')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-settings');

        $this->addMediaCollection('logo-sidebar-dark')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-settings');

        $this->addMediaCollection('logo-sidebar-light')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-settings');

        $this->addMediaCollection('logo-email')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-settings');
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
