<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Database\Factories\FormSubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Forms\Casts\ResponseValue;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;

/**
 * @mixin IdeHelperFormSubmissionResponse
 */
class FormSubmissionResponse extends Model
{
    /** @use HasFactory<FormSubmissionFactory> */
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

    /**
     * @return BelongsTo<FormField, $this>
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(FormField::class, 'field_uid', 'uid');
    }

    /**
     * @return BelongsTo<FormSubmission, $this>
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class, 'submission_id');
    }
}
