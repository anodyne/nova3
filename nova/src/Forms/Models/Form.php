<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Carbon\CarbonImmutable;
use Database\Factories\FormFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Nova\Forms\Data\FormOptions;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Events\FormCreated;
use Nova\Forms\Events\FormDeleted;
use Nova\Forms\Events\FormUpdated;
use Nova\Forms\Models\Builders\FormBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $key
 * @property FormType $type
 * @property string|null $description
 * @property bool $is_locked
 * @property FormOptions|null $options
 * @property array<array-key, mixed>|null $fields
 * @property array<array-key, mixed>|null $published_fields
 * @property BasicStatus $status
 * @property CarbonImmutable|null $published_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, FormField> $formFields
 * @property-read int|null $form_fields_count
 * @property-read bool $has_published_fields
 * @property-read string|null $rendered_block_content
 * @property-read Collection<int, FormSubmission> $submissions
 * @property-read int|null $submissions_count
 * @property-read array $validation_messages
 * @property-read array $validation_rules
 *
 * @method static FormBuilder<static>|Form active()
 * @method static FormBuilder<static>|Form basic()
 * @method static FormFactory factory($count = null, $state = [])
 * @method static FormBuilder<static>|Form inactive()
 * @method static FormBuilder<static>|Form key(string $key)
 * @method static FormBuilder<static>|Form newModelQuery()
 * @method static FormBuilder<static>|Form newQuery()
 * @method static FormBuilder<static>|Form query()
 * @method static FormBuilder<static>|Form searchFor($search)
 * @method static FormBuilder<static>|Form submissible()
 * @method static FormBuilder<static>|Form whereCreatedAt($value)
 * @method static FormBuilder<static>|Form whereDescription($value)
 * @method static FormBuilder<static>|Form whereFields($value)
 * @method static FormBuilder<static>|Form whereId($value)
 * @method static FormBuilder<static>|Form whereIsLocked($value)
 * @method static FormBuilder<static>|Form whereKey($value)
 * @method static FormBuilder<static>|Form whereName($value)
 * @method static FormBuilder<static>|Form whereOptions($value)
 * @method static FormBuilder<static>|Form wherePrefixedId($value)
 * @method static FormBuilder<static>|Form wherePublishedAt($value)
 * @method static FormBuilder<static>|Form wherePublishedFields($value)
 * @method static FormBuilder<static>|Form whereStatus($value)
 * @method static FormBuilder<static>|Form whereType($value)
 * @method static FormBuilder<static>|Form whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(FormBuilder::class)]
class Form extends Model
{
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }

    protected $casts = [
        'is_locked' => 'boolean',
        'fields' => 'array',
        'published_at' => 'datetime',
        'published_fields' => 'array',
        'status' => BasicStatus::class,
        'type' => FormType::class,
        'options' => FormOptions::class,
    ];

    protected $dispatchesEvents = [
        'created' => FormCreated::class,
        'deleted' => FormDeleted::class,
        'updated' => FormUpdated::class,
    ];

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

    public function formFields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()
            ->logExcept([
                'fields',
                'published_fields',
            ]);
    }

    public function hasPublishedFields(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->published_fields)
        );
    }

    public function renderedBlockContent(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->generateBlockContent()
        );
    }

    /**
     * @return HasMany<FormSubmission, $this>
     */
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
                    return collect($this->published_fields ?? [])
                        ->filter(fn ($field) => data_get($field, 'data.details.required', false))
                        ->flatMap(fn ($field): array => [
                            sprintf('%s.%s.required', 'values', data_get($field, 'data.attrs.id')) => data_get($field, 'data.details.label').' field is required',
                        ])
                        ->all();
                }

                return collect($this->published_fields ?? [])
                    ->filter(fn ($field) => data_get($field, 'data.details.required', false))
                    ->flatMap(fn ($field): array => [
                        sprintf('%s.%s.required', $form->key, data_get($field, 'data.attrs.id')) => data_get($field, 'data.details.label').' field is required',
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
                    return collect($this->published_fields ?? [])
                        ->filter(fn ($field) => data_get($field, 'data.details.required', false))
                        ->flatMap(fn ($field): array => [
                            sprintf('%s.%s', 'values', data_get($field, 'data.attrs.id')) => 'required',
                        ])
                        ->all();
                }

                return collect($this->published_fields ?? [])
                    ->filter(fn ($field) => data_get($field, 'data.details.required', false))
                    ->flatMap(fn ($field): array => [
                        sprintf('%s.%s', $this->key, data_get($field, 'data.attrs.id')) => 'required',
                    ])
                    ->all();
            }
        );
    }

    protected function generateBlockContent(): ?string
    {
        $content = null;

        if (filled($this->published_fields)) {
            foreach ($this->published_fields as $published_field) {
                if (View::exists('components.form-fields.'.$published_field['type'])) {
                    $content .= Blade::render('<x-dynamic-component :$component :$details :$attrs />', [
                        'component' => 'form-fields.'.$published_field['type'],
                        'details' => data_get($published_field, 'data.details'),
                        'attrs' => data_get($published_field, 'data.attrs'),
                    ]);
                }
            }
        }

        return $content;
    }
}
