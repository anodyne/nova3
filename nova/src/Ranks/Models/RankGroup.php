<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Ranks\Enums\RankGroupStatus;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
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
        'status' => RankGroupStatus::class,
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

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name rank group was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name rank group was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): RankGroupBuilder
    {
        return new RankGroupBuilder($query);
    }
}
