<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Builders\ApplicationBuilder;
use Nova\Characters\Models\Character;
use Nova\Discussions\Concerns\Discussable;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class Application extends Model
{
    use Discussable;
    use HasFactory;
    use HasPrefixedId;

    protected $fillable = [
        'character_id',
        'user_id',
        'result',
        'decision_date',
        'decision_message',
        'ip_address',
    ];

    protected $casts = [
        'decision_date' => 'datetime',
        'result' => ApplicationResult::class,
    ];

    public function applicationFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereHas('form', fn (Builder $query): Builder => $query->key('applicationInfo'));
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'application_review')
            ->withPivot(['result', 'comments'])
            ->using(ApplicationReview::class);
    }

    public function acceptedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Accept);
    }

    public function deniedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Deny);
    }

    public function noResultReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivotNull('result');
    }

    public function newEloquentBuilder($query): ApplicationBuilder
    {
        return new ApplicationBuilder($query);
    }
}
