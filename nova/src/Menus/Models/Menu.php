<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Menus\Models\Builders\MenuBuilder;

class Menu extends Model
{
    protected $fillable = ['name', 'key'];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->ordered();
    }

    public function newEloquentBuilder($query): MenuBuilder
    {
        return new MenuBuilder($query);
    }
}
