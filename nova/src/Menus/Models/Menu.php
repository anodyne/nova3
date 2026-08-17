<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Models\Model;
use Nova\Menus\Models\Builders\MenuBuilder;

/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $status
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, MenuItem> $items
 * @property-read int|null $items_count
 *
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu active()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu inactive()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu newModelQuery()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu newQuery()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu public()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu query()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereCreatedAt($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereId($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereKey($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereName($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereStatus($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
