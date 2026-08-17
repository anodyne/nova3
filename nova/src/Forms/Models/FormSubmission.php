<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Nova\Forms\Models\Builders\FormSubmissionBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $form_id
 * @property string|null $owner_type
 * @property int|null $owner_id
 * @property array<array-key, mixed>|null $meta
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Forms\Models\Form $form
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmissionResponse> $responses
 * @property-read int|null $responses_count
 * @property-read string|null $title_field
 * @method static \Database\Factories\FormSubmissionFactory factory($count = null, $state = [])
 * @method static FormSubmissionBuilder<static>|FormSubmission forForm(\Nova\Forms\Models\Form|int $form)
 * @method static FormSubmissionBuilder<static>|FormSubmission newModelQuery()
 * @method static FormSubmissionBuilder<static>|FormSubmission newQuery()
 * @method static FormSubmissionBuilder<static>|FormSubmission onlySubmissionsForCurrentUser()
 * @method static FormSubmissionBuilder<static>|FormSubmission ownerIsUser(\Nova\Users\Models\User $user)
 * @method static FormSubmissionBuilder<static>|FormSubmission query()
 * @method static FormSubmissionBuilder<static>|FormSubmission whereCreatedAt($value)
 * @method static FormSubmissionBuilder<static>|FormSubmission whereFormId($value)
 * @method static FormSubmissionBuilder<static>|FormSubmission whereId($value)
 * @method static FormSubmissionBuilder<static>|FormSubmission whereMeta($value)
 * @method static FormSubmissionBuilder<static>|FormSubmission whereOwnerId($value)
 * @method static FormSubmissionBuilder<static>|FormSubmission whereOwnerType($value)
 * @method static FormSubmissionBuilder<static>|FormSubmission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(FormSubmissionBuilder::class)]
class FormSubmission extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function owner(): MorphTo
    {
        return $this->morphTo('owner');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(FormSubmissionResponse::class, 'submission_id');
    }

    public function titleField(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->responses()->where('field_uid', $this->form->options?->submissionTitleField)->first()?->value
        );
    }
}
