<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Carbon\CarbonImmutable;
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
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $key
 * @property General|null $general
 * @property Email|null $email
 * @property Appearance|null $appearance
 * @property Characters|null $characters
 * @property Discord|null $discord
 * @property PostingActivity|null $posting_activity
 * @property ContentRatings|null $ratings
 * @property Applications|null $applications
 * @property Dashboard|null $dashboard
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings custom()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings default()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings newModelQuery()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings newQuery()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings query()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereAppearance($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereApplications($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereCharacters($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereCreatedAt($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereDashboard($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereDiscord($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereEmail($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereGeneral($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereId($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereKey($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings wherePostingActivity($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereRatings($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereUpdatedAt($value)
 *
 * @mixin \Eloquent
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
