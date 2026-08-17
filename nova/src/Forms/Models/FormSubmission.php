<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Nova\Forms\Models\Builders\FormSubmissionBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property int $form_id
 * @property string|null $owner_type
 * @property int|null $owner_id
 * @property array<array-key, mixed>|null $meta
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Form $form
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $owner
 * @property-read Collection<int, FormSubmissionResponse> $responses
 * @property-read int|null $responses_count
 * @property-read string|null $title_field
 *
 * @method static \Database\Factories\FormSubmissionFactory factory($count = null, $state = [])
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission forForm(\Nova\Forms\Models\Form|int $form)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission newModelQuery()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission newQuery()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission onlySubmissionsForCurrentUser()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission ownerIsUser(\Nova\Users\Models\User $user)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission query()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereCreatedAt($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereFormId($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereId($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereMeta($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereOwnerId($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereOwnerType($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(FormSubmissionBuilder::class)]
class FormSubmission extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'meta' => 'array',
    ];

    protected $fillable = ['meta'];

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
            get: function (): ?string {
                $value = $this->responses()
                    ->where('field_uid', $this->form->options?->submissionTitleField)
                    ->first()?->getAttribute('value');

                return is_string($value) ? $value : null;
            }
        );
    }
}
