<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $dispatchesEvents = [
        'created' => Events\FormCreated::class,
        'deleted' => Events\FormDeleted::class,
        'updated' => Events\FormUpdated::class,
    ];

    protected $fillable = ['name', 'key', 'description'];

    public function blocks()
    {
        return $this->belongsToMany(Block::class, 'form_block')
            ->using(FormBlock::class)
            ->withPivot('id', 'order_column', 'parent_id', 'settings')
            ->orderBy('pivot_order_column');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name was {$eventName}"
            );
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name was {$eventName}";
    }

    public function newEloquentBuilder($query): FormBuilder
    {
        return new FormBuilder($query);
    }
}
