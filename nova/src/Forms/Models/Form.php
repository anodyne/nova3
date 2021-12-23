<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Forms\Events;
use Nova\Forms\Models\Builders\FormBuilder;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

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
            ->withPivot('id', 'sort', 'parent_id', 'settings')
            ->orderBy('pivot_sort');
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
