<?php

namespace Nova\Notes\Models;

use Nova\Notes\Events;
use Nova\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Nova\Notes\Models\Builders\NoteBuilder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'source' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => Events\NoteCreated::class,
        'deleted' => Events\NoteDeleted::class,
        'updated' => Events\NoteUpdated::class,
    ];

    protected $fillable = ['user_id', 'title', 'content', 'source', 'summary'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.title note was {$eventName}";
    }

    public function newEloquentBuilder($query): NoteBuilder
    {
        return new NoteBuilder($query);
    }
}
