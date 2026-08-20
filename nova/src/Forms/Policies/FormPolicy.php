<?php

declare(strict_types=1);

namespace Nova\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Forms\Models\Form;
use Nova\Users\Models\User;

class FormPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('form.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Form $form): Response
    {
        return $user->isAbleTo('form.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('form.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function updateAny(User $user): Response
    {
        return $user->isAbleTo('form.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Form $form): Response
    {
        return $this->updateAny($user);
    }

    public function deleteAny(User $user): Response
    {
        return $user->isAbleTo('form.delete')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Form $form): Response
    {
        return $this->deleteAny($user)->allowed() && ! $form->is_locked
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, Form $form): Response
    {
        return $user->isAbleTo('form.create') && $user->isAbleTo('form.update') && ! $form->is_locked
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Form $form): Response
    {
        return $this->denyAsNotFound();
    }

    public function forceDelete(User $user, Form $form): Response
    {
        return $this->denyAsNotFound();
    }

    public function design(User $user, Form $form): Response
    {
        return $this->update($user, $form);
    }
}
