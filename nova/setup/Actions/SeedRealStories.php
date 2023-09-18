<?php

declare(strict_types=1);

namespace Nova\Setup\Actions;

use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Actions\Migration\MigrateMissionsAndPosts;

class SeedRealStories
{
    use AsAction;

    public string $commandSignature = 'nova:seed-real-stories';

    public function handle(): void
    {
        MigrateMissionsAndPosts::run();
    }

    public function asCommand(Command $command): void
    {
        $this->handle();

        $command->info('Finished');
    }
}
