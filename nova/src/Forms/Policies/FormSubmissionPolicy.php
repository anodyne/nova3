<?php

declare(strict_types=1);

namespace Nova\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Forms\Models\FormSubmission;
use Nova\Users\Models\User;

class FormSubmissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('form.*')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, FormSubmission $submission): Response
    {
        return $user->isAbleTo('form.view')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('form.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, FormSubmission $submission): Response
    {
        return $user->isAbleTo('form.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, FormSubmission $submission): Response
    {
        return $user->isAbleTo('form.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(User $user, FormSubmission $submission): Response
    {
        return $user->isAbleTo('form.create') && $user->isAbleTo('form.update')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, FormSubmission $submission): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, FormSubmission $submission): Response
    {
        return $this->denyWithStatus(418);
    }

    public function design(User $user, FormSubmission $submission): Response
    {
        return $this->update($user, $submission);
    }
}
