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
