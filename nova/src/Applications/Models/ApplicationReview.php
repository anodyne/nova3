<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Users\Models\User;

/**
 * @mixin IdeHelperApplicationReview
 */
class ApplicationReview extends Pivot
{
    use HasTableHelpers;
    use HasUuids;
    use LogsActivity;

    protected $casts = [
        'result' => ApplicationResult::class,
    ];

    /**
     * @return BelongsTo<Application, $this>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isAccepted(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->result === ApplicationResult::Accept
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isDenied(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->result === ApplicationResult::Deny
        );
    }

    public function formSubmission(): ?FormSubmission
    {
        return FormSubmission::query()
            ->where('form_id', Form::key('applicationReview')->first()?->id)
            ->whereMorphRelation('owner', User::class, 'id', $this->user_id)
            ->where('meta->application_id', $this->application_id)
            ->first();
    }
}
