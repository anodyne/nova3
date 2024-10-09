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

class BuildSearchIndex
{
    use AsAction;

    public string $commandSignature = 'nova:build-search-index';

    public function handle(): void
    {
        foreach ($this->getSearchables() as $model) {
            $this->buildSearchIndexForModel($model);
        }
    }

    public function asCommand(Command $command): void
    {
        foreach ($this->getSearchables() as $model) {
            $this->buildSearchIndexForModel($model);

            $command->info('Search index built for model: '.$model);
        }

        $command->newLine();
        $command->info('Search index has been built.');
    }

    protected function buildSearchIndexForModel(string $model): void
    {
        Artisan::call('scout:import', ['model' => $model]);
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
