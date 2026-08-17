<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property int $application_id
 * @property int $user_id
 * @property ApplicationResult|null $result
 * @property string|null $comments
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Application $application
 * @property-read bool $is_accepted
 * @property-read bool $is_denied
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereUserId($value)
 *
 * @mixin \Eloquent
 */
class ApplicationReview extends Pivot
{
    use HasTableHelpers;
    use LogsActivity;

    protected $casts = [
        'result' => ApplicationResult::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
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

    public function isDenied(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->result === ApplicationResult::Deny
        );
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
