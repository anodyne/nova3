<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Characters\Models\Character;
use Nova\Ranks\Enums\RankItemStatus;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankItemBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class RankItem extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'order_column' => 'integer',
        'status' => RankItemStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankItemCreated::class,
        'deleted' => Events\RankItemDeleted::class,
        'updated' => Events\RankItemUpdated::class,
    ];

    protected $fillable = [
        'base_image', 'overlay_image', 'group_id', 'name_id', 'order_column', 'status',
    ];

    protected $table = 'rank_items';

    public function characters()
    {
        return $this->hasMany(Character::class, 'rank_id');
    }

    public function group()
    {
        return $this->belongsTo(RankGroup::class, 'group_id');
    }

    public function name()
    {
        return $this->belongsTo(RankName::class, 'name_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name rank item was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): RankItemBuilder
    {
        return new RankItemBuilder($query);
    }
}
