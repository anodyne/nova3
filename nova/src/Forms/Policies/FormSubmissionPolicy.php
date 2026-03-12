<?php

declare(strict_types=1);

namespace Nova\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;

class FormSubmissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->allow();
    }

    public function view(User $user, FormSubmission $submission): Response
    {
        if ($submission->form->type !== FormType::Basic) {
            return $this->denyAsNotFound();
        }

        if ($user->isAbleTo('form-submission.view-all')) {
            return $this->allow();
        }

        if ($submission->owner_type === 'user' && $submission->owner_id === $user->id) {
            return $this->allow();
        }

        return $this->denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function update(User $user, FormSubmission $submission): Response
    {
        return $this->denyAsNotFound();
    }

    public function delete(User $user, FormSubmission $submission): Response
    {
        return $user->isAbleTo('form-submission.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, FormSubmission $submission): Response
    {
        return $this->denyAsNotFound();
    }

    public function restore(User $user, FormSubmission $submission): Response
    {
        return $this->denyAsNotFound();
    }

    public function forceDelete(User $user, FormSubmission $submission): Response
    {
        return $this->denyAsNotFound();
    }

    public function manage(User $user): Response
    {
        return $user->isAbleTo('form-submission.view-all') || $user->isAbleTo('form-submission.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}
