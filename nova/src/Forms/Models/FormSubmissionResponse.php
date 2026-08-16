<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Forms\Casts\ResponseValue;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $submission_id
 * @property string $field_type
 * @property string $field_uid
 * @property $value
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Forms\Models\FormField|null $field
 * @property-read \Nova\Forms\Models\FormSubmission $submission
 * @method static \Database\Factories\FormSubmissionResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereFieldUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmissionResponse whereValue($value)
 * @mixin \Eloquent
 */
class FormSubmissionResponse extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'id',
        'submission_id',
        'field_uid',
        'field_type',
        'value',
    ];

    protected $casts = [
        'value' => ResponseValue::class,
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
