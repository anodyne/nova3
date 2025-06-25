<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Models\Model;
use Nova\Menus\Models\Builders\MenuBuilder;

#[UseEloquentBuilder(MenuBuilder::class)]
class Menu extends Model
{
    protected $fillable = ['name', 'key'];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->ordered();
    }
}
