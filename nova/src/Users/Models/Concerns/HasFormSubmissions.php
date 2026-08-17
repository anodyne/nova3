<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nova\Forms\Models\FormSubmission;

trait HasFormSubmissions
{
    /**
     * @return MorphMany<FormSubmission, $this>
     */
    public function formSubmissions(): MorphMany
    {
        return $this->morphMany(FormSubmission::class, 'owner');
    }

    /**
     * @return MorphOne<FormSubmission, $this>
     */
    public function userFormSubmission(): MorphOne
    {
        return $this
            ->morphOne(FormSubmission::class, 'owner')
            ->whereRelation('form', 'key', '=', 'userBio');
    }
}
