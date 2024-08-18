<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Spatie\ModelStates\Transition;

class InactiveToActive extends Transition
{
    public function __construct(
        protected User $user
    ) {}

    public function handle(): User
    {
        $this->user->status = Active::class;

        $this->user->save();

        $roles = Role::isDefault()->pluck('id')->all();

        $this->user->syncRoles($roles);

        return $this->user;
    }
}
