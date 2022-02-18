<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RankGroup extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'sort' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankGroupCreated::class,
        'updated' => Events\RankGroupUpdated::class,
        'deleted' => Events\RankGroupDeleted::class,
    ];

    protected $fillable = ['name', 'sort'];

    protected $table = 'rank_groups';

    public function ranks()
    {
        return $this->hasMany(RankItem::class, 'group_id')
            ->orderBy('sort', 'asc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name rank group was {$eventName}"
            );
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return RankGroupBuilder
     */
    public function newEloquentBuilder($query): RankGroupBuilder
    {
        return new RankGroupBuilder($query);
    }
}
