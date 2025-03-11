<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

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
        'created' => Events\RankGroupCreated::class,
        'updated' => Events\RankGroupUpdated::class,
        'deleted' => Events\RankGroupDeleted::class,
    ];

    public function ranks(): HasMany
    {
        return $this->hasMany(RankItem::class, 'group_id')
            ->orderBy('order_column', 'asc');
    }

    public function newEloquentBuilder($query): RankGroupBuilder
    {
        return new RankGroupBuilder($query);
    }
}
