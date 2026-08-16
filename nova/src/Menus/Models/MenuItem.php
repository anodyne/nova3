<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Anodyne\TablerIcons\Tabler;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Events\MenuItemCreated;
use Nova\Menus\Events\MenuItemDeleted;
use Nova\Menus\Events\MenuItemUpdated;
use Nova\Menus\Models\Builders\MenuItemBuilder;
use Nova\Menus\Observers\MenuItemObserver;
use Nova\Pages\Models\Page;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property string $label
 * @property Tabler|null $icon
 * @property LinkType $link_type
 * @property int|null $page_id
 * @property string|null $url
 * @property LinkTarget $target
 * @property BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MenuItem> $items
 * @property-read int|null $items_count
 * @property-read mixed $link
 * @property-read \Nova\Menus\Models\Menu $menu
 * @property-read Page|null $page
 * @property-read MenuItem|null $parent
 * @method static MenuItemBuilder<static>|MenuItem active()
 * @method static \Database\Factories\MenuItemFactory factory($count = null, $state = [])
 * @method static MenuItemBuilder<static>|MenuItem inactive()
 * @method static MenuItemBuilder<static>|MenuItem newModelQuery()
 * @method static MenuItemBuilder<static>|MenuItem newQuery()
 * @method static MenuItemBuilder<static>|MenuItem ordered(string $direction = 'asc')
 * @method static MenuItemBuilder<static>|MenuItem public()
 * @method static MenuItemBuilder<static>|MenuItem query()
 * @method static MenuItemBuilder<static>|MenuItem searchFor($search)
 * @method static MenuItemBuilder<static>|MenuItem whereCreatedAt($value)
 * @method static MenuItemBuilder<static>|MenuItem whereIcon($value)
 * @method static MenuItemBuilder<static>|MenuItem whereId($value)
 * @method static MenuItemBuilder<static>|MenuItem whereLabel($value)
 * @method static MenuItemBuilder<static>|MenuItem whereLinkType($value)
 * @method static MenuItemBuilder<static>|MenuItem whereMenuId($value)
 * @method static MenuItemBuilder<static>|MenuItem whereOrderColumn($value)
 * @method static MenuItemBuilder<static>|MenuItem wherePageId($value)
 * @method static MenuItemBuilder<static>|MenuItem whereParentId($value)
 * @method static MenuItemBuilder<static>|MenuItem whereStatus($value)
 * @method static MenuItemBuilder<static>|MenuItem whereTarget($value)
 * @method static MenuItemBuilder<static>|MenuItem whereUpdatedAt($value)
 * @method static MenuItemBuilder<static>|MenuItem whereUrl($value)
 * @mixin \Eloquent
 */
#[ObservedBy([MenuItemObserver::class])]
#[UseEloquentBuilder(MenuItemBuilder::class)]
class MenuItem extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $fillable = [
        'icon',
        'label',
        'link_type',
        'order_column',
        'page_id',
        'parent_id',
        'status',
        'target',
        'url',
    ];

    protected $casts = [
        'icon' => Tabler::class,
        'link_type' => LinkType::class,
        'order_column' => 'integer',
        'page_id' => 'integer',
        'parent_id' => 'integer',
        'status' => BasicStatus::class,
        'target' => LinkTarget::class,
    ];

    protected $dispatchesEvents = [
        'created' => MenuItemCreated::class,
        'deleted' => MenuItemDeleted::class,
        'updated' => MenuItemUpdated::class,
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->link_type) {
                LinkType::Page => route($this->page->key),
                default => $this->url,
            }
        );
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('menu_id', $this->menu_id);
    }
}
