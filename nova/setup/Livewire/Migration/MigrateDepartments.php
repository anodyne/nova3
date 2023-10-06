<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Nova\Departments\Models\Department;
use Nova\Setup\Models\Legacy\Department as LegacyDepartment;

class MigrateDepartments extends MigrationStep
{
    public string $label = 'Departments';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    public function getPendingMigrationCountProperty(): int
    {
        return LegacyDepartment::count();
    }

    public function getCompletedMigrationCountProperty(): int
    {
        return Department::count();
    }
}
