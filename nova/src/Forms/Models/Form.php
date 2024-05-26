<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Forms\Data\FormOptions;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Events;
use Nova\Forms\Models\Builders\FormBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'key',
        'type',
        'description',
        'status',
        'fields',
        'published_fields',
        'published_at',
        'options',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'fields' => 'array',
        'published_at' => 'datetime',
        'published_fields' => 'array',
        'status' => FormStatus::class,
        'type' => FormType::class,
        'options' => FormOptions::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\FormCreated::class,
        'deleted' => Events\FormDeleted::class,
        'updated' => Events\FormUpdated::class,
    ];

    public function formData(): HasMany
    {
        return $this->hasMany(FormData::class, 'form_key', 'key');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
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
