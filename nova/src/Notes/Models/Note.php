<?php

declare(strict_types=1);

namespace Nova\Notes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Notes\Events;
use Nova\Notes\Models\Builders\NoteBuilder;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Note extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'source' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => Events\NoteCreated::class,
        'deleted' => Events\NoteDeleted::class,
        'updated' => Events\NoteUpdated::class,
    ];

    protected $fillable = ['user_id', 'title', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name note was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): NoteBuilder
    {
        return new NoteBuilder($query);
    }
}
