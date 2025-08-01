<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Nova\Applications\Events\ApplicationAccepted;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Events;
use Nova\Applications\Models\Builders\ApplicationBuilder;
use Nova\Characters\Models\Character;
use Nova\Discussions\Concerns\Discussable;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

#[UseEloquentBuilder(ApplicationBuilder::class)]
class Application extends Model
{
    use Discussable;
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity;

    protected $fillable = [
        'character_id',
        'decision_date',
        'decision_message',
        'ip_address',
        'result',
        'user_id',
    ];

    protected $casts = [
        'decision_date' => 'datetime',
        'result' => ApplicationResult::class,
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationAccepted::class,
    ];

    public function acceptedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Accept);
    }

    public function applicationFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereRelation('form', 'key', '=', 'applicationInfo');
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function deniedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Deny);
    }

    public function noResultReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivotNull('result');
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'application_review')
            ->withPivot(['result', 'comments'])
            ->using(ApplicationReview::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
