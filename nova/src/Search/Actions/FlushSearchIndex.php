<?php

declare(strict_types=1);

namespace Nova\Search\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Models\Announcement;
use Nova\Characters\Models\Character;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class FlushSearchIndex
{
    use AsAction;

    public string $commandSignature = 'nova:flush-search-index';

    public function handle(string $model): void
    {
        foreach ($this->getSearchables() as $model) {
            $this->flushSearchIndexForModel($model);
        }
    }

    public function asCommand(Command $command): void
    {
        foreach ($this->getSearchables() as $model) {
            $this->flushSearchIndexForModel($model);

            $command->info('Search index flushed for model: '.$model);
        }

        $command->newLine();
        $command->info('Search index has been flushed.');
    }

    protected function flushSearchIndexForModel(string $model): void
    {
        Artisan::call('scout:flush', ['model' => $model]);
    }

    protected function getSearchables(): array
    {
        return [
            Announcement::class,
            Character::class,
            Post::class,
            Story::class,
        ];
    }
}
