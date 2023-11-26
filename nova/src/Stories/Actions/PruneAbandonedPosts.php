<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class PruneAbandonedPosts
{
    use AsAction;

    public string $commandSignature = 'nova:prune-abandoned-posts';

    public string $commandDescription = 'Prunes any posts started 2+ days ago with a status of Started.';

    public function handle(): int
    {
        return Post::query()->abandoned()->delete();
    }

    public function asCommand(Command $command): void
    {
        $deletedRows = $this->handle();

        $command->info('Removed '.$deletedRows.' abandoned posts');
    }
}
