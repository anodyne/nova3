<?php

declare(strict_types=1);

namespace Nova\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Forms\Models\Form;
use Nova\Users\Models\User;

class FormPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAbleTo('form.*')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function view(User $user, Form $form)
    {
        return $user->isAbleTo('form.view')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user)
    {
        return $user->isAbleTo('form.create')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function update(User $user, Form $form)
    {
        return $user->isAbleTo('form.update')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Form $form)
    {
        return $user->isAbleTo('form.delete') && ! $form->locked
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function duplicate(User $user, Form $form)
    {
        return $user->isAbleTo('form.create') && $user->isAbleTo('form.update') && ! $form->locked
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function restore(User $user, Form $form)
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Form $form)
    {
        return $this->denyWithStatus(418);
    }
}
