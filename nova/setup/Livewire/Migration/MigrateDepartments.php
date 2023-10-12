<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Departments\Models\Department;
use Nova\Setup\Models\Legacy\Department as LegacyDepartment;

class MigrateDepartments extends MigrationStep
{
    public string $label = 'Departments';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyDepartment::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Department::count();
    }
}
