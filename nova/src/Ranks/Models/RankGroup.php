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
 * @mixin IdeHelperRankGroup
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
