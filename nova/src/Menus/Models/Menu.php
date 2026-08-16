<?php

declare(strict_types=1);

namespace Nova\Menus\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Models\Model;
use Nova\Menus\Models\Builders\MenuBuilder;

/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Menus\Models\MenuItem> $items
 * @property-read int|null $items_count
 * @method static MenuBuilder<static>|Menu active()
 * @method static MenuBuilder<static>|Menu inactive()
 * @method static MenuBuilder<static>|Menu newModelQuery()
 * @method static MenuBuilder<static>|Menu newQuery()
 * @method static MenuBuilder<static>|Menu public()
 * @method static MenuBuilder<static>|Menu query()
 * @method static MenuBuilder<static>|Menu whereCreatedAt($value)
 * @method static MenuBuilder<static>|Menu whereId($value)
 * @method static MenuBuilder<static>|Menu whereKey($value)
 * @method static MenuBuilder<static>|Menu whereName($value)
 * @method static MenuBuilder<static>|Menu whereStatus($value)
 * @method static MenuBuilder<static>|Menu whereUpdatedAt($value)
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
