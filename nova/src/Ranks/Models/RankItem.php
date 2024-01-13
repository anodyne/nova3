<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected $table = 'rank_items';

    protected $fillable = [
        'base_image', 'overlay_image', 'group_id', 'name_id', 'order_column', 'status',
    ];

    protected $with = ['name'];

    protected $casts = [
        'order_column' => 'integer',
        'status' => RankItemStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankItemCreated::class,
        'deleted' => Events\RankItemDeleted::class,
        'updated' => Events\RankItemUpdated::class,
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

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name rank item was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name rank item was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): RankItemBuilder
    {
        return new RankItemBuilder($query);
    }
}
