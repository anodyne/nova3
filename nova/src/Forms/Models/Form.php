<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Events;
use Nova\Forms\Models\Builders\FormBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'locked' => 'boolean',
        'status' => FormStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\FormCreated::class,
        'deleted' => Events\FormDeleted::class,
        'updated' => Events\FormUpdated::class,
    ];

    protected $fillable = ['name', 'key', 'description', 'status'];

    public function blocks()
    {
        return $this->belongsToMany(Block::class, 'form_block')
            ->using(FormBlock::class)
            ->withPivot('id', 'order_column', 'parent_id', 'settings')
            ->orderBy('pivot_order_column');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name form was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name form was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): FormBuilder
    {
        return new FormBuilder($query);
    }
}
