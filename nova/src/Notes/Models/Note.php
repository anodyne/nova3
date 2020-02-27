<?php

namespace Nova\Notes\Models;

use Nova\Notes\Events;
use Nova\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Nova\Notes\Models\Builders\NoteBuilder;
use Spatie\Activitylog\Traits\LogsActivity;

class Note extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $dispatchesEvents = [
        'created' => Events\NoteCreated::class,
        'updated' => Events\NoteUpdated::class,
        'deleted' => Events\NoteDeleted::class,
    ];

    protected $fillable = ['user_id', 'title', 'content'];

    /**
     * The author of the note.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.title note was {$eventName}";
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return NoteBuilder
     */
    public function newEloquentBuilder($query): NoteBuilder
    {
        return new NoteBuilder($query);
    }
}
