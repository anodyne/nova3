<?php

declare(strict_types=1);

namespace Nova\Setup\Actions;

use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class SetDatabaseInitialState
{
    use AsAction;

    public string $commandSignature = 'nova:set-db-state';

    public function handle(): void
    {
        collect([
            new Database\EnsureAdvancedPagesAreCreated,
            new Database\EnsureBasicPagesAreCreated,
            new Database\EnsureFormsAreCreated,
        ])->each->handle();
    }

    public function asCommand(Command $command): void
    {
        $this->handle();

        $command->info('Database initial state set!');
    }
}
