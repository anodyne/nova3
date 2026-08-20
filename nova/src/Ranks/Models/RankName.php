<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Ranks\Events\RankNameCreated;
use Nova\Ranks\Events\RankNameDeleted;
use Nova\Ranks\Events\RankNameUpdated;
use Nova\Ranks\Models\Builders\RankNameBuilder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @mixin IdeHelperRankName
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
