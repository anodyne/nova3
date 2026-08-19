<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Carbon\CarbonImmutable;
use Database\Factories\RankGroupFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Ranks\Events\RankGroupCreated;
use Nova\Ranks\Events\RankGroupDeleted;
use Nova\Ranks\Events\RankGroupUpdated;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
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
 * @method static RankGroupBuilder<static>|RankGroup active()
 * @method static RankGroupFactory factory($count = null, $state = [])
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
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(RankGroupBuilder::class)]
class RankGroup extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'order_column' => 'integer',
        'status' => BasicStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => RankGroupCreated::class,
        'updated' => RankGroupUpdated::class,
        'deleted' => RankGroupDeleted::class,
    ];

    protected $fillable = ['name', 'order_column', 'status'];

    protected $table = 'rank_groups';

    protected $with = ['ranks'];

    public function ranks(): HasMany
    {
        return $this->hasMany(RankItem::class, 'group_id')
            ->orderBy('order_column', 'asc');
    }
}
