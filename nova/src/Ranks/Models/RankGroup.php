<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Ranks\Events\RankGroupCreated;
use Nova\Ranks\Events\RankGroupDeleted;
use Nova\Ranks\Events\RankGroupUpdated;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property string $name
 * @property BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Ranks\Models\RankItem> $ranks
 * @property-read int|null $ranks_count
 * @method static RankGroupBuilder<static>|RankGroup active()
 * @method static \Database\Factories\RankGroupFactory factory($count = null, $state = [])
 * @method static RankGroupBuilder<static>|RankGroup inactive()
 * @method static RankGroupBuilder<static>|RankGroup newModelQuery()
 * @method static RankGroupBuilder<static>|RankGroup newQuery()
 * @method static RankGroupBuilder<static>|RankGroup ordered(string $direction = 'asc')
 * @method static RankGroupBuilder<static>|RankGroup query()
 * @method static RankGroupBuilder<static>|RankGroup searchFor($search)
 * @method static RankGroupBuilder<static>|RankGroup whereCreatedAt($value)
 * @method static RankGroupBuilder<static>|RankGroup whereId($value)
 * @method static RankGroupBuilder<static>|RankGroup whereName($value)
 * @method static RankGroupBuilder<static>|RankGroup whereOrderColumn($value)
 * @method static RankGroupBuilder<static>|RankGroup whereStatus($value)
 * @method static RankGroupBuilder<static>|RankGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(RankGroupBuilder::class)]
class RankGroup extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $table = 'rank_groups';

    protected $fillable = ['name', 'order_column', 'status'];

    protected $with = ['ranks'];

    protected $casts = [
        'order_column' => 'integer',
        'status' => BasicStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => RankGroupCreated::class,
        'updated' => RankGroupUpdated::class,
        'deleted' => RankGroupDeleted::class,
    ];

    public function ranks(): HasMany
    {
        return $this->hasMany(RankItem::class, 'group_id')
            ->orderBy('order_column', 'asc');
    }
}
