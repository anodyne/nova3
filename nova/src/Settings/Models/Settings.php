<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\General;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Spatie\MediaLibrary\HasMedia;

class Settings extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'settings';

    protected $casts = [
        'general' => General::class,
        'email' => Email::class,
        'appearance' => Appearance::class,
        'characters' => Characters::class,
        'meta_tags' => MetaTags::class,
        'discord' => Discord::class,
        'posting_activity' => PostingActivity::class,
        'ratings' => ContentRatings::class,
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
    ];

    public function newEloquentBuilder($query): SettingsBuilder
    {
        return new SettingsBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media');

        $this->addMediaCollection('email-logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media');
    }

    public static function getMediaPath(): string
    {
        return 'settings/{model_id}/{media_id}/';
    }
}
