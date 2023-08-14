<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Ranks\Enums\RankNameStatus;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankNameBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class RankName extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $table = 'rank_names';

    protected $fillable = ['name', 'order_column', 'status'];

    protected $casts = [
        'order_column' => 'integer',
        'status' => RankNameStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankNameCreated::class,
        'updated' => Events\RankNameUpdated::class,
        'deleted' => Events\RankNameDeleted::class,
    ];

    public function ranks(): HasMany
    {
        return $this->hasMany(RankItem::class, 'name_id')
            ->orderBy('order_column', 'asc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name rank name was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name rank name was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): RankNameBuilder
    {
        return new RankNameBuilder($query);
    }
}
