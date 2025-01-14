<?php

declare(strict_types=1);

namespace Nova\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Settings\Data;
use Nova\Settings\Models\Builders\SettingsBuilder;
use Spatie\MediaLibrary\HasMedia;

class Settings extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'settings';

    protected $casts = [
        'general' => Data\General::class,
        'email' => Data\Email::class,
        'appearance' => Data\Appearance::class,
        'characters' => Data\Characters::class,
        'meta_tags' => Data\MetaTags::class,
        'discord' => Data\Discord::class,
        'posting_activity' => Data\PostingActivity::class,
        'ratings' => Data\ContentRatings::class,
        'applications' => Data\Applications::class,
        'writing_dashboard' => Data\WritingDashboard::class,
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
        'writing_dashboard',
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
