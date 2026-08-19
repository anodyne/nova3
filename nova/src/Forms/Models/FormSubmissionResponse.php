<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Carbon\CarbonImmutable;
use Database\Factories\FormSubmissionResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Forms\Casts\ResponseValue;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property int $submission_id
 * @property string $field_type
 * @property string $field_uid
 * @property mixed|null $value
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read FormField|null $field
 * @property-read FormSubmission $submission
 *
 * @method static FormSubmissionResponseFactory factory($count = null, $state = [])
 * @method static Builder<static>|FormSubmissionResponse newModelQuery()
 * @method static Builder<static>|FormSubmissionResponse newQuery()
 * @method static Builder<static>|FormSubmissionResponse query()
 * @method static Builder<static>|FormSubmissionResponse whereCreatedAt($value)
 * @method static Builder<static>|FormSubmissionResponse whereFieldType($value)
 * @method static Builder<static>|FormSubmissionResponse whereFieldUid($value)
 * @method static Builder<static>|FormSubmissionResponse whereId($value)
 * @method static Builder<static>|FormSubmissionResponse whereSubmissionId($value)
 * @method static Builder<static>|FormSubmissionResponse whereUpdatedAt($value)
 * @method static Builder<static>|FormSubmissionResponse whereValue($value)
 *
 * @mixin \Eloquent
 */
class FormSubmissionResponse extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'value' => ResponseValue::class,
    ];

    protected $fillable = [
        'id',
        'submission_id',
        'field_uid',
        'field_type',
        'value',
    ];

    public function field(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'field_uid', 'uid');
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class, 'submission_id');
    }
}
