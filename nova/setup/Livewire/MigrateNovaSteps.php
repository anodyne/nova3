<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Livewire\Component;
use Nova\Setup\Livewire\Migration\MigrateUsers;

class MigrateNovaSteps extends Component
{
    public bool $isFinished = false;

    public bool $isRunning = false;

    protected $listeners = ['finishMigration'];

    public function startMigration(): void
    {
        $this->isRunning = true;

        $this->emit('startMigrationStep', ['step' => MigrateUsers::class]);
    }

    public function finishMigration(): void
    {
        $this->isRunning = false;
        $this->isFinished = true;
    }

    public function render()
    {
        return view('setup.migrate-nova.steps.index')
            ->extends('layouts.setup');
    }
}
