<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Database\Factories\RankItemFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Characters\Models\Character;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Ranks\Events\RankItemCreated;
use Nova\Ranks\Events\RankItemDeleted;
use Nova\Ranks\Events\RankItemUpdated;
use Nova\Ranks\Models\Builders\RankItemBuilder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @mixin IdeHelperRankItem
 */
#[UseEloquentBuilder(RankItemBuilder::class)]
class RankItem extends Model implements Sortable
{
    /** @use HasFactory<RankItemFactory> */
    use HasFactory;

    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'order_column' => 'integer',
        'status' => BasicStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => RankItemCreated::class,
        'deleted' => RankItemDeleted::class,
        'updated' => RankItemUpdated::class,
    ];

    protected $fillable = [
        'base_image', 'overlay_image', 'group_id', 'name_id', 'order_column', 'status',
    ];

    protected $table = 'rank_items';

    /** @var list<string> */
    protected $with = ['name'];

    /**
     * @return HasMany<Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'rank_id');
    }

    /**
     * @return BelongsTo<RankGroup, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(RankGroup::class, 'group_id');
    }

    /**
     * @return BelongsTo<RankName, $this>
     */
    public function name(): BelongsTo
    {
        return $this->belongsTo(RankName::class, 'name_id');
    }
}
