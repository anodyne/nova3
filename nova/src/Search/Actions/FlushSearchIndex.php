<?php

declare(strict_types=1);

namespace Nova\Search\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Nova\Announcements\Models\Announcement;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class FlushSearchIndex extends Action
{
    public function handle(string $model): void
    {
        foreach ($this->getSearchables() as $model) {
            $this->flushSearchIndexForModel($model);
        }
    }

    protected function flushSearchIndexForModel(string $model): void
    {
        Artisan::call('scout:flush', ['model' => $model]);
    }

    /** @return list<class-string<Model>> */
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
