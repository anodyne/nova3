<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Models\Model;
use Nova\Menus\Models\Builders\MenuBuilder;

/**
 * @mixin IdeHelperMenu
 */
#[UseEloquentBuilder(MenuBuilder::class)]
class Menu extends Model
{
    protected $fillable = ['name', 'key'];

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function items(): HasMany
    {
        /** @var HasMany<MenuItem, $this> $relation */
        $relation = $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->ordered();

        return $relation;
    }
}
