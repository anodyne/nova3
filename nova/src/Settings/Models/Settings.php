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
 * @property int $id
 * @property string $key
 * @property \Bag\Bag|null $general
 * @property \Bag\Bag|null $email
 * @property \Bag\Bag|null $appearance
 * @property \Bag\Bag|null $characters
 * @property \Bag\Bag|null $discord
 * @property \Bag\Bag|null $posting_activity
 * @property \Bag\Bag|null $ratings
 * @property \Bag\Bag|null $applications
 * @property \Bag\Bag|null $dashboard
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static SettingsBuilder<static>|Settings custom()
 * @method static SettingsBuilder<static>|Settings default()
 * @method static SettingsBuilder<static>|Settings newModelQuery()
 * @method static SettingsBuilder<static>|Settings newQuery()
 * @method static SettingsBuilder<static>|Settings query()
 * @method static SettingsBuilder<static>|Settings whereAppearance($value)
 * @method static SettingsBuilder<static>|Settings whereApplications($value)
 * @method static SettingsBuilder<static>|Settings whereCharacters($value)
 * @method static SettingsBuilder<static>|Settings whereCreatedAt($value)
 * @method static SettingsBuilder<static>|Settings whereDashboard($value)
 * @method static SettingsBuilder<static>|Settings whereDiscord($value)
 * @method static SettingsBuilder<static>|Settings whereEmail($value)
 * @method static SettingsBuilder<static>|Settings whereGeneral($value)
 * @method static SettingsBuilder<static>|Settings whereId($value)
 * @method static SettingsBuilder<static>|Settings whereKey($value)
 * @method static SettingsBuilder<static>|Settings wherePostingActivity($value)
 * @method static SettingsBuilder<static>|Settings whereRatings($value)
 * @method static SettingsBuilder<static>|Settings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
