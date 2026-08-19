<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Announcements\Models\Announcement;
use Nova\Setup\Actions\Migration\MigrateNewsItem;
use Nova\Setup\Models\Upgrade;

/**
 * @property-read int $pendingMigrationCount
 * @property-read int $completedMigrationCount
 */
class MigrateNewsItems extends MigrationStep
{
    public string $label = 'News items';

    public function handleMigration(): void
    {
        $userMap = Upgrade::type('user')->get();

        $this->query()
            ->whereNotIn('news_id', Upgrade::type('news-item')->pluck('old_id'))
            ->chunkById(100, function (Collection $newsItems) use ($userMap): void {
                foreach ($newsItems as $newItem) {
                    MigrateNewsItem::run(
                        model: $newItem,
                        users: $userMap
                    );
                }
            }, 'news_id');
    }

    #[Computed]
    public function pendingMigrationCount(): int
    {
        return $this->query()->count();
    }

    #[Computed]
    public function completedMigrationCount(): int
    {
        return Announcement::count();
    }

    protected function query(): Builder
    {
        return DB::connection('nova2')
            ->table('news')
            ->join('news_categories', 'news.news_cat', '=', 'news_categories.newscat_id')
            ->join('users', 'news.news_author_user', '=', 'users.userid');
    }

    protected function getBatchJobs(): Collection
    {
        return $this->query()
            ->get()
            ->map(fn ($newsItem): JobDecorator => MigrateNewsItem::makeJob(model: $newsItem));
    }
}
