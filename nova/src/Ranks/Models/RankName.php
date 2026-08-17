<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Ranks\Events\RankNameCreated;
use Nova\Ranks\Events\RankNameDeleted;
use Nova\Ranks\Events\RankNameUpdated;
use Nova\Ranks\Models\Builders\RankNameBuilder;
use Spatie\Activitylog\Models\Activity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property string $name
 * @property BasicStatus $status
 * @property int|null $order_column
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, RankItem> $ranks
 * @property-read int|null $ranks_count
 *
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName active()
 * @method static \Database\Factories\RankNameFactory factory($count = null, $state = [])
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName inactive()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName newModelQuery()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName newQuery()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName ordered(string $direction = 'asc')
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName query()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName searchFor($search)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereCreatedAt($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereId($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereName($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereOrderColumn($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereStatus($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(RankNameBuilder::class)]
class RankName extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'order_column' => 'integer',
        'status' => BasicStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => RankNameCreated::class,
        'updated' => RankNameUpdated::class,
        'deleted' => RankNameDeleted::class,
    ];

    protected $fillable = ['name', 'order_column', 'status'];

    protected $table = 'rank_names';

    public function ranks(): HasMany
    {
        return $this->hasMany(RankItem::class, 'name_id')
            ->orderBy('order_column', 'asc');
    }
}
