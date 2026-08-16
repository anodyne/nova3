<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

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
 * @property int $id
 * @property int $group_id
 * @property int $name_id
 * @property string $base_image
 * @property string|null $overlay_image
 * @property BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Nova\Ranks\Models\RankGroup $group
 * @property-read \Nova\Ranks\Models\RankName $name
 * @method static RankItemBuilder<static>|RankItem active()
 * @method static \Database\Factories\RankItemFactory factory($count = null, $state = [])
 * @method static RankItemBuilder<static>|RankItem group($group)
 * @method static RankItemBuilder<static>|RankItem inactive()
 * @method static RankItemBuilder<static>|RankItem name($name)
 * @method static RankItemBuilder<static>|RankItem newModelQuery()
 * @method static RankItemBuilder<static>|RankItem newQuery()
 * @method static RankItemBuilder<static>|RankItem ordered(string $direction = 'asc')
 * @method static RankItemBuilder<static>|RankItem query()
 * @method static RankItemBuilder<static>|RankItem searchFor($search)
 * @method static RankItemBuilder<static>|RankItem whereBaseImage($value)
 * @method static RankItemBuilder<static>|RankItem whereCreatedAt($value)
 * @method static RankItemBuilder<static>|RankItem whereGroupId($value)
 * @method static RankItemBuilder<static>|RankItem whereId($value)
 * @method static RankItemBuilder<static>|RankItem whereNameId($value)
 * @method static RankItemBuilder<static>|RankItem whereOrderColumn($value)
 * @method static RankItemBuilder<static>|RankItem whereOverlayImage($value)
 * @method static RankItemBuilder<static>|RankItem whereStatus($value)
 * @method static RankItemBuilder<static>|RankItem whereUpdatedAt($value)
 * @method static RankItemBuilder<static>|RankItem withRankName()
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(RankItemBuilder::class)]
class RankItem extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $table = 'rank_items';

    protected $fillable = [
        'base_image', 'overlay_image', 'group_id', 'name_id', 'order_column', 'status',
    ];

    protected $with = ['name'];

    protected $casts = [
        'group_id' => 'integer',
        'name_id' => 'integer',
        'order_column' => 'integer',
        'status' => BasicStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => RankItemCreated::class,
        'deleted' => RankItemDeleted::class,
        'updated' => RankItemUpdated::class,
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'rank_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(RankGroup::class, 'group_id');
    }

    public function name(): BelongsTo
    {
        return $this->belongsTo(RankName::class, 'name_id');
    }
}
