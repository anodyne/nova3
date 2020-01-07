<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Roles\DataTransferObjects\RoleData;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UpdateRole
{
    public function execute(Role $role, RoleData $data)
    {
        $role->update($data->except('abilities')->toArray());

        $abilities = collect($data->abilities)->map(function ($ability) {
            return Bouncer::ability()->firstOrCreate(['name' => $ability]);
        });

        Bouncer::sync($role)->abilities($abilities);

        return $role->refresh();
    }
}
