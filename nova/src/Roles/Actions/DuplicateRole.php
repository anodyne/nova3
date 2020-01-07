<?php

namespace Nova\Roles\Actions;

use Nova\Roles\Models\Role;
use Nova\Foundation\WordGenerator;
use Silber\Bouncer\BouncerFacade as Bouncer;

class DuplicateRole
{
    public function execute(Role $originalRole)
    {
        $role = $originalRole->replicate();

        $role->name = implode('-', (new WordGenerator)->words(2));
        $role->title = "Copy of {$role->title}";

        $role->save();

        Bouncer::sync($role)->abilities($originalRole->getAbilities());

        return $role->refresh();
    }
}
