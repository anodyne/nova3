<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
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
use Spatie\Activitylog\Models\Activity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
 * @property CarbonImmutable|null $published_at
 * @property bool $content_can_be_edited
 * @property string|null $heading
 * @property string|null $subheading
 * @property string|null $intro
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $is_advanced
 * @property-read bool $is_basic
 * @property-read bool $is_previewable
 * @property-read bool $is_published
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, MenuItem> $menuItems
 * @property-read int|null $menu_items_count
 * @property-read string|null $rendered_block_content
 *
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page active()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page advanced()
 * @method static \Nova\Pages\Models\Collections\PagesCollection<int, static> all($columns = ['*'])
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page basic()
 * @method static \Database\Factories\PageFactory factory($count = null, $state = [])
 * @method static \Nova\Pages\Models\Collections\PagesCollection<int, static> get($columns = ['*'])
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page inactive()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page key(string $key)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page newModelQuery()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page newQuery()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page public()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page query()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page searchFor(string $search)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page verb(\Nova\Pages\Enums\PageVerb $verb)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereBlocks($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereContentCanBeEdited($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereCreatedAt($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereHeading($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereId($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereIntro($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereKey($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereLayout($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereMiddleware($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereName($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page wherePrefixedId($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page wherePublishedAt($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page wherePublishedBlocks($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereResource($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSeoDescription($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSeoKeywords($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSeoTitle($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereStatus($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSubheading($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereUri($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereVerb($value)
 *
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
