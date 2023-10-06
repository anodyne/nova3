<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Nova\Setup\Models\Legacy\Post as LegacyPost;

class MigratePosts extends MigrationStep
{
    public string $label = 'Mission posts';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    public function getPendingMigrationCountProperty(): int
    {
        return LegacyPost::count();
    }

    public function getCompletedMigrationCountProperty(): int
    {
        return Post::query()
            ->where('post_type_id', '!=', PostType::where('key', 'personal')->first()->id)
            ->count();
    }
}
