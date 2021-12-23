<?php

declare(strict_types=1);

namespace Nova\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Forms\Models\Form;
use Nova\Users\Models\User;

class FormPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('form.*');
    }

    public function view(User $user, Form $form): bool
    {
        return $user->isAbleTo('form.view');
    }

    public function create(User $user): bool
    {
        return $user->isAbleTo('form.create');
    }

    public function update(User $user, Form $form): bool
    {
        return $user->isAbleTo('form.update');
    }

    public function delete(User $user, Form $form): bool
    {
        return $user->isAbleTo('form.delete') && ! $form->locked;
    }

    public function duplicate(User $user, Form $form): bool
    {
        return $user->isAbleTo('form.create')
            && $user->isAbleTo('form.update')
            && ! $form->locked;
    }

    public function restore(User $user, Form $form): bool
    {
        return false;
    }

    public function forceDelete(User $user, Form $form): bool
    {
        return false;
    }
}
