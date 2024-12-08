<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Setup\Enums\SetupType;
use Nova\Setup\Livewire\Migration\MigrateUsers;

#[Layout('layouts.setup', ['type' => SetupType::Install])]
class MigrateNovaSteps extends Component
{
    public bool $isFinished = false;

    public bool $isRunning = false;

    public function startMigration(): void
    {
        $this->isRunning = true;

        $this->dispatch('startMigrationStep', ['step' => MigrateUsers::class]);
    }

    #[On('finishMigration')]
    public function finishMigration(): void
    {
        $this->isRunning = false;
        $this->isFinished = true;
    }

    public function render()
    {
        return view('setup.migrate-nova.steps.index');
    }
}
