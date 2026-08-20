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
 * @mixin IdeHelperFormSubmission
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
