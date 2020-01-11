<?php

namespace Nova\Roles\Actions;

use Silber\Bouncer\BouncerFacade as Bouncer;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateUsersRoles
{
    public function execute(RoleAssignmentData $data)
    {
        $data->role->users->diff($data->users)->each->retract($data->role);

        $data->users->diff($data->role->users)->each->assign($data->role);

        Bouncer::refresh();
    }
}
