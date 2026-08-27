<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Anodyne\TablerIcons\Tabler;
use Database\Factories\MenuItemFactory;
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
 * @mixin IdeHelperMenuItem
 */
#[ObservedBy([MenuItemObserver::class])]
#[UseEloquentBuilder(MenuItemBuilder::class)]
class MenuItem extends Model implements Sortable
{
    /** @use HasFactory<MenuItemFactory> */
    use HasFactory;

    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'icon' => Tabler::class,
        'link_type' => LinkType::class,
        'order_column' => 'integer',
        'status' => BasicStatus::class,
        'target' => LinkTarget::class,
    ];

    protected $dispatchesEvents = [
        'created' => MenuItemCreated::class,
        'deleted' => MenuItemDeleted::class,
        'updated' => MenuItemUpdated::class,
    ];

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

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return BelongsTo<Menu, $this>
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * @return BelongsTo<Page, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * @return BelongsTo<MenuItem, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return Attribute<string, never>
     */
    public function link(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->link_type) {
                LinkType::Page => route($this->page->key),
                default => $this->url,
            }
        );
    }

    /**
     * @return Builder<MenuItem>
     */
    public function buildSortQuery(): Builder
    {
        return static::query()->where('menu_id', $this->menu_id);
    }
}
