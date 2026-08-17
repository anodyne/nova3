<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Carbon\CarbonImmutable;
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
 * @property mixed $value
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read FormField|null $field
 * @property-read FormSubmission $submission
 *
 * @method static \Database\Factories\FormSubmissionResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereFieldUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereValue($value)
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
