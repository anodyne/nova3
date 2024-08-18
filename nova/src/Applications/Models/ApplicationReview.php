<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;

class ApplicationReview extends Pivot
{
    protected $casts = [
        'result' => ApplicationResult::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formSubmission(): ?FormSubmission
    {
        return FormSubmission::query()
            ->where('form_id', Form::key('applicationReview')->first()?->id)
            ->whereMorphRelation('owner', User::class, 'id', $this->user_id)
            ->where('meta->application_id', $this->application_id)
            ->first();
    }

    public function isAccepted(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->result === ApplicationResult::Accept
        );
    }

    public function isRejected(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->result === ApplicationResult::Reject
        );
    }
}
