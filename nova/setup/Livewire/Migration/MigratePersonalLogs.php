<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Nova\Setup\Models\Legacy\PersonalLog as LegacyPersonalLog;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

class MigratePersonalLogs extends MigrationStep
{
    public string $label = 'Personal logs';

    public function runMigrationStep(): void
    {
        sleep(5);
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return LegacyPersonalLog::count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Post::query()
            ->where('post_type_id', PostType::where('key', 'personal')->first()->id)
            ->count();
    }
}
