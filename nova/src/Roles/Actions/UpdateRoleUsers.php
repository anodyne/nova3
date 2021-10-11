<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

class UpdateRoleUsers
{
    use AsAction;

    public function handle(RoleAssignmentData $data): void
    {
        $data->role->users()->sync($data->users);
    }
}
