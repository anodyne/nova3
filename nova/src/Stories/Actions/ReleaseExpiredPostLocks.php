<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class ReleaseExpiredPostLocks
{
    use AsAction;

    public string $commandSignature = 'nova:release-expired-post-locks';

    public function handle(): void
    {
        Post::query()
            ->hasExpiredPostLock()
            ->update([
                'locked_at' => null,
                'locked_by' => null,
            ]);
    }

    public function asCommand(Command $command): void
    {
        $this->handle();

        $command->info('Done!');
    }
}
