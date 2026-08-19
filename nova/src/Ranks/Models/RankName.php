<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Carbon\CarbonImmutable;
use Database\Factories\RankNameFactory;
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
 * @method static RankNameBuilder<static>|RankName active()
 * @method static RankNameFactory factory($count = null, $state = [])
 * @method static RankNameBuilder<static>|RankName inactive()
 * @method static RankNameBuilder<static>|RankName newModelQuery()
 * @method static RankNameBuilder<static>|RankName newQuery()
 * @method static RankNameBuilder<static>|RankName ordered(string $direction = 'asc')
 * @method static RankNameBuilder<static>|RankName query()
 * @method static RankNameBuilder<static>|RankName searchFor($search)
 * @method static RankNameBuilder<static>|RankName whereCreatedAt($value)
 * @method static RankNameBuilder<static>|RankName whereId($value)
 * @method static RankNameBuilder<static>|RankName whereName($value)
 * @method static RankNameBuilder<static>|RankName whereOrderColumn($value)
 * @method static RankNameBuilder<static>|RankName whereStatus($value)
 * @method static RankNameBuilder<static>|RankName whereUpdatedAt($value)
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
