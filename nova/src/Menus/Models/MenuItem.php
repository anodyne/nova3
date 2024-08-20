<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Enums\MenuStatus;
use Nova\Menus\Events;
use Nova\Menus\Models\Builders\MenuItemBuilder;
use Nova\Pages\Models\Page;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuItem extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'label',
        'icon',
        'url',
        'page_id',
        'link_type',
        'order_column',
        'status',
        'parent_id',
        'target',
    ];

    protected $casts = [
        'link_type' => LinkType::class,
        'status' => MenuStatus::class,
        'page_id' => 'integer',
        'parent_id' => 'integer',
        'order_column' => 'integer',
        'target' => LinkTarget::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\MenuItemCreated::class,
        'deleted' => Events\MenuItemDeleted::class,
        'updated' => Events\MenuItemUpdated::class,
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

    public function iconName(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => str($this->icon)->prepend('tabler-')->toString()
        );
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

    public function newEloquentBuilder($query): MenuItemBuilder
    {
        return new MenuItemBuilder($query);
    }
}
