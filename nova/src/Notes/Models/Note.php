<?php

declare(strict_types=1);

namespace Nova\Notes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Notes\Events;
use Nova\Notes\Models\Builders\NoteBuilder;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Note extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['user_id', 'title', 'content'];

    protected $dispatchesEvents = [
        'created' => Events\NoteCreated::class,
        'deleted' => Events\NoteDeleted::class,
        'updated' => Events\NoteUpdated::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.title note was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.title note was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): NoteBuilder
    {
        return new NoteBuilder($query);
    }
}
