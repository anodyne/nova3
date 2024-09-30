<?php

declare(strict_types=1);

namespace Nova\Announcements\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Nova\Announcements\Models\Announcement;
use Nova\Users\Models\User;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $this->allow();
    }

    public function view(User $user, Announcement $announcement): Response
    {
        return $this->allow();
    }

    public function create(User $user): Response
    {
        return $user->isAbleTo('announcement.create')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Announcement $announcement): Response
    {
        return $user->isAbleTo('announcement.update')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Announcement $announcement): Response
    {
        return $user->isAbleTo('announcement.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Announcement $announcement): Response
    {
        return $this->denyWithStatus(418);
    }

    public function forceDelete(User $user, Announcement $announcement): Response
    {
        return $this->denyWithStatus(418);
    }

    public function manage(User $user): Response
    {
        return $user->isAbleTo(['announcement.create', 'announcement.update', 'announcement.delete'])
            ? $this->allow()
            : $this->deny();
    }
}
