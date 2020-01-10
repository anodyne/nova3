<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Roles\DataTransferObjects\RoleData;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateRole
{
    public function execute(RoleData $data): Role
    {
        $role = Bouncer::role()->firstOrCreate(
            $data->only('name', 'title')->toArray()
        );

        $abilities = collect($data->abilities)->map(function ($ability) {
            return Bouncer::ability()->firstOrCreate(['name' => $ability]);
        });

        Bouncer::sync($role)->abilities($abilities);

        return $role->refresh();
    }
}
