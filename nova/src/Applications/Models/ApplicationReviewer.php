<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Database\Factories\ApplicationReviewerFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\Builders\ApplicationReviewerBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\Scopes\ActiveUsers;
use Nova\Users\Models\User;

/**
 * @mixin IdeHelperApplicationReviewer
 */
#[ScopedBy(ActiveUsers::class)]
#[UseEloquentBuilder(ApplicationReviewerBuilder::class)]
class ApplicationReviewer extends Model
{
    /** @use HasFactory<ApplicationReviewerFactory> */
    use HasFactory;

    use LogsActivity;

    protected $casts = [
        'conditions' => 'array',
        'type' => ReviewerType::class,
    ];

    protected $fillable = [
        'conditions',
        'type',
        'user_id',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
