<?php

declare(strict_types=1);

namespace Nova\Applications\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Users\Models\User;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        if ($user->isAbleTo('application.approve')) {
            return $this->allow();
        }

        return ApplicationReview::where('user_id', Auth::id())->count() > 0
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Application $application): Response
    {
        if ($user->isAbleTo('application.approve')) {
            return $this->allow();
        }

        return $application->reviews->contains($user)
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->denyWithStatus(418);
    }

    public function update(User $user, Application $application): Response
    {
        return $this->denyWithStatus(418);
    }

    public function deleteAny(User $user): Response
    {
        return $this->denyWithStatus(418);
    }

    public function delete(User $user, Application $application): Response
    {
        return $this->deleteAny($user);
    }

    public function duplicate(User $user, Application $application): Response
    {
        return $this->denyWithStatus(418);
    }

    public function restore(User $user, Application $application): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Application $application): Response
    {
        return $this->denyWithStatus(418);
    }

    public function decide(User $user, Application $application): Response
    {
        return $user->isAbleTo('application.approve') && $application->result === ApplicationResult::Pending
            ? $this->allow()
            : $this->deny();
    }

    public function vote(User $user, Application $application): Response
    {
        if ($application->result !== ApplicationResult::Pending) {
            return $this->deny();
        }

        if ($application->reviews->contains($user)) {
            $userReview = $application->reviews()->wherePivot('user_id', $user->id)->first();

            if (blank($userReview->pivot->result) || (filled($userReview->pivot->result) && settings('applications.allowVoteChanging'))) {
                return $this->allow();
            }
        }

        return $this->deny();
    }
}
