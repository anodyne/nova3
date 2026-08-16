<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

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
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $uri
 * @property string|null $key
 * @property PageVerb $verb
 * @property string|null $resource
 * @property string $layout
 * @property array<array-key, mixed>|null $middleware
 * @property array<array-key, mixed>|null $blocks
 * @property array<array-key, mixed>|null $published_blocks
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property BasicStatus $status
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property bool $content_can_be_edited
 * @property string|null $heading
 * @property string|null $subheading
 * @property string|null $intro
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $is_advanced
 * @property-read bool $is_basic
 * @property-read bool $is_previewable
 * @property-read bool $is_published
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MenuItem> $menuItems
 * @property-read int|null $menu_items_count
 * @property-read string|null $rendered_block_content
 * @method static PageBuilder<static>|Page active()
 * @method static PageBuilder<static>|Page advanced()
 * @method static PagesCollection<int, static> all($columns = ['*'])
 * @method static PageBuilder<static>|Page basic()
 * @method static \Database\Factories\PageFactory factory($count = null, $state = [])
 * @method static PagesCollection<int, static> get($columns = ['*'])
 * @method static PageBuilder<static>|Page inactive()
 * @method static PageBuilder<static>|Page key(string $key)
 * @method static PageBuilder<static>|Page newModelQuery()
 * @method static PageBuilder<static>|Page newQuery()
 * @method static PageBuilder<static>|Page public()
 * @method static PageBuilder<static>|Page query()
 * @method static PageBuilder<static>|Page searchFor(string $search)
 * @method static PageBuilder<static>|Page verb(\Nova\Pages\Enums\PageVerb $verb)
 * @method static PageBuilder<static>|Page whereBlocks($value)
 * @method static PageBuilder<static>|Page whereContentCanBeEdited($value)
 * @method static PageBuilder<static>|Page whereCreatedAt($value)
 * @method static PageBuilder<static>|Page whereHeading($value)
 * @method static PageBuilder<static>|Page whereId($value)
 * @method static PageBuilder<static>|Page whereIntro($value)
 * @method static PageBuilder<static>|Page whereKey($value)
 * @method static PageBuilder<static>|Page whereLayout($value)
 * @method static PageBuilder<static>|Page whereMiddleware($value)
 * @method static PageBuilder<static>|Page whereName($value)
 * @method static PageBuilder<static>|Page wherePrefixedId($value)
 * @method static PageBuilder<static>|Page wherePublishedAt($value)
 * @method static PageBuilder<static>|Page wherePublishedBlocks($value)
 * @method static PageBuilder<static>|Page whereResource($value)
 * @method static PageBuilder<static>|Page whereSeoDescription($value)
 * @method static PageBuilder<static>|Page whereSeoKeywords($value)
 * @method static PageBuilder<static>|Page whereSeoTitle($value)
 * @method static PageBuilder<static>|Page whereStatus($value)
 * @method static PageBuilder<static>|Page whereSubheading($value)
 * @method static PageBuilder<static>|Page whereUpdatedAt($value)
 * @method static PageBuilder<static>|Page whereUri($value)
 * @method static PageBuilder<static>|Page whereVerb($value)
 * @mixin \Eloquent
 */
#[CollectedBy(PagesCollection::class)]
#[ObservedBy([PageObserver::class])]
#[UseEloquentBuilder(PageBuilder::class)]
class Page extends Model implements HasMedia
{
    use HasFactory;
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
        'created' => PageCreated::class,
        'deleted' => PageDeleted::class,
        'updated' => PageUpdated::class,
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

    public function renderedBlockContent(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->generateBlockContent()
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

    protected function generateBlockContent(): ?string
    {
        $content = null;

        if (filled($this->published_blocks)) {
            foreach ($this->published_blocks as $publishedBlock) {
                if (View::exists('components.pages.blocks.'.$publishedBlock['type'])) {
                    $content .= Blade::render('<x-dynamic-component :$component :$container :$content :$block />', [
                        'component' => 'pages.blocks.'.$publishedBlock['type'],
                        'container' => data_get($publishedBlock, 'data.container'),
                        'content' => data_get($publishedBlock, 'data.content'),
                        'block' => data_get($publishedBlock, 'data.block'),
                    ]);
                }
            }
        }

        return $content;
    }
}
