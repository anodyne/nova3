<?php

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FormSubmission extends Model
{
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
}