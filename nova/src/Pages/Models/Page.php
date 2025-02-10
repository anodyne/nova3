<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Menus\Models\MenuItem;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Events;
use Nova\Pages\Models\Collections\PagesCollection;
use Nova\Pages\Observers\PageObserver;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

#[CollectedBy(PagesCollection::class)]
#[ObservedBy([PageObserver::class])]
class Page extends Model implements HasMedia
{
    use HasPrefixedId;
    use InteractsWithMedia;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }

    protected $fillable = [
        'blocks',
        'heading',
        'intro',
        'key',
        'layout',
        'middleware',
        'name',
        'published_blocks',
        'resource',
        'seo_description',
        'seo_keywords',
        'seo_title',
        'status',
        'subheading',
        'uri',
        'verb',
    ];

    protected $casts = [
        'blocks' => 'array',
        'content_can_be_edited' => 'boolean',
        'middleware' => 'array',
        'published_at' => 'datetime',
        'published_blocks' => 'array',
        'status' => BasicStatus::class,
        'verb' => PageVerb::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\PageCreated::class,
        'deleted' => Events\PageDeleted::class,
        'updated' => Events\PageUpdated::class,
    ];

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function isAdvanced(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->resource !== null
        );
    }

    public function isBasic(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->resource === null
        );
    }

    public function isPreviewable(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                if (filled($this->blocks) && blank($this->published_blocks)) {
                    return true;
                }

                if ($this->blocks !== $this->published_blocks) {
                    return true;
                }

                return false;
            }
        );
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->published_at)
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'blocks',
            'published_blocks',
            'intro',
        ]);
    }

    public function newEloquentBuilder($query): Builders\PageBuilder
    {
        return new Builders\PageBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('block-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->useDisk('media-pages');

        $this->addMediaCollection('seo-image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
            ->useDisk('media-pages');
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
