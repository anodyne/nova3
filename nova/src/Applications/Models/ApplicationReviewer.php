<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\Builders\ApplicationReviewerBuilder;
use Nova\Applications\Models\Scopes\ActiveUsers;
use Nova\Users\Models\User;

#[ScopedBy(ActiveUsers::class)]
class ApplicationReviewer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'conditions',
    ];

    protected $casts = [
        'conditions' => 'array',
        'type' => ReviewerType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newEloquentBuilder($query): ApplicationReviewerBuilder
    {
        return new ApplicationReviewerBuilder($query);
    }
}
