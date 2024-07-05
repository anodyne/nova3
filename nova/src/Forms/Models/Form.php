<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function formFields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function validationMessages(): Attribute
    {
        $form = $this;

        return Attribute::make(
            get: function () use ($form): array {
                if ($form->type === FormType::Basic) {
                    return collect(data_get($this->published_fields, 'content', []))
                        ->filter(fn ($field) => data_get($field, 'attrs.values.required', false))
                        ->flatMap(fn ($field) => [
                            sprintf('%s.%s.required', 'values', data_get($field, 'attrs.values.uid')) => data_get($field, 'attrs.values.label').' field is required',
                        ])
                        ->all();
                }

                return collect(data_get($this->published_fields, 'content', []))
                    ->filter(fn ($field) => data_get($field, 'attrs.values.required', false))
                    ->flatMap(fn ($field) => [
                        sprintf('%s.%s.required', $form->key, data_get($field, 'attrs.values.uid')) => data_get($field, 'attrs.values.label').' field is required',
                    ])
                    ->all();
            }
        );
    }

    public function validationRules(): Attribute
    {
        $form = $this;

        return Attribute::make(
            get: function () use ($form): array {
                if ($form->type === FormType::Basic) {
                    return collect(data_get($this->published_fields, 'content', []))
                        ->filter(fn ($field) => data_get($field, 'attrs.values.required', false))
                        ->flatMap(fn ($field) => [
                            sprintf('%s.%s', 'values', data_get($field, 'attrs.values.uid')) => 'required',
                        ])
                        ->all();
                }

                return collect(data_get($this->published_fields, 'content', []))
                    ->filter(fn ($field) => data_get($field, 'attrs.values.required', false))
                    ->flatMap(fn ($field) => [
                        sprintf('%s.%s', $this->key, data_get($field, 'attrs.values.uid')) => 'required',
                    ])
                    ->all();
            }
        );
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
