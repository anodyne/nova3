<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Menus\Models\MenuItem;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Events\PageCreated;
use Nova\Pages\Events\PageDeleted;
use Nova\Pages\Events\PageUpdated;
use Nova\Pages\Models\Builders\PageBuilder;
use Nova\Pages\Models\Collections\PagesCollection;
use Nova\Pages\Observers\PageObserver;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @mixin IdeHelperPage
 */
#[CollectedBy(PagesCollection::class)]
#[ObservedBy([PageObserver::class])]
#[UseEloquentBuilder(PageBuilder::class)]
class Page extends Model implements HasMedia
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    use HasPrefixedId;
    use InteractsWithMedia;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }

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
        'created' => PageCreated::class,
        'deleted' => PageDeleted::class,
        'updated' => PageUpdated::class,
    ];

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

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'blocks',
            'published_blocks',
            'intro',
        ]);
    }

    /** @return Attribute<bool, never> */
    public function isAdvanced(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->resource !== null
        );
    }

    /** @return Attribute<bool, never> */
    public function isBasic(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->resource === null
        );
    }

    /** @return Attribute<bool, never> */
    public function isPreviewable(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                if (filled($this->blocks) && blank($this->published_blocks)) {
                    return true;
                }

                return $this->blocks !== $this->published_blocks;
            }
        );
    }

    /** @return Attribute<bool, never> */
    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->published_at)
        );
    }

    /** @return HasMany<MenuItem, $this> */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
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

    /** @return Attribute<?string, never> */
    public function renderedBlockContent(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->generateBlockContent()
        );
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }

    protected function generateBlockContent(): ?string
    {
        $content = null;

        if (filled($this->published_blocks)) {
            foreach ($this->published_blocks as $published_block) {
                if (View::exists('components.pages.blocks.'.$published_block['type'])) {
                    $content .= Blade::render('<x-dynamic-component :$component :$container :$content :$block />', [
                        'component' => 'pages.blocks.'.$published_block['type'],
                        'container' => data_get($published_block, 'data.container'),
                        'content' => data_get($published_block, 'data.content'),
                        'block' => data_get($published_block, 'data.block'),
                    ]);
                }
            }
        }

        return $content;
    }
}
