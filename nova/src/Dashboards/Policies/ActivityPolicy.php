<?php

declare(strict_types=1);

namespace Nova\Dashboards\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAbleTo('system.activity')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Activity $activity): Response
    {
        return $user->isAbleTo('system.activity')
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->deny();
    }

    public function update(User $user, Activity $activity): Response
    {
        return $this->deny();
    }

    public function deleteAny(User $user): Response
    {
        return $this->deny();
    }

    public function delete(User $user, Activity $activity): Response
    {
        return $this->deny();
    }

    public function restore(User $user, Activity $activity): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Activity $activity): Response
    {
        return $this->denyWithStatus(418);
    }
}
