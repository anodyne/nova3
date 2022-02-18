<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Characters\Models\Character;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankItemBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RankItem extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'sort' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankItemCreated::class,
        'deleted' => Events\RankItemDeleted::class,
        'updated' => Events\RankItemUpdated::class,
    ];

    protected $fillable = [
        'base_image', 'overlay_image', 'group_id', 'name_id', 'sort'
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

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return RankItemBuilder
     */
    public function newEloquentBuilder($query): RankItemBuilder
    {
        return new RankItemBuilder($query);
    }
}
