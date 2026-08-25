<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyNewsItem object{
 *     news_author_user: int|null,
 *     news_title: string,
 *     newscat_name: string|null,
 *     news_content: string,
 *     news_status: string,
 *     news_date: int|null,
 *     news_last_update: int|null,
 *     news_id: int
 * }
 */
class MigrateNewsItem
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    /**
     * @param  LegacyNewsItem  $model
     * @param  Collection<int, Upgrade>|null  $users
     */
    public function handle(object $model, ?Collection $users): void
    {
        $newUserId = $this->getNewId(
            id: $model->news_author_user,
            collection: $users,
            upgradeKey: 'user'
        );

        DB::transaction(function () use ($model, $newUserId): void {
            $newsId = DB::table('announcements')->insertGetId([
                'title' => $model->news_title,
                'category' => $model->newscat_name,
                'user_id' => $newUserId,
                'content' => $model->news_content,
                'status' => match ($model->news_status) {
                    'saved' => 'draft',
                    'pending' => 'pending',
                    default => 'published',
                },
                'published_at' => $date = $this->convertDate($model->news_date),
                'created_at' => $created = $date ?? now('UTC'),
                'updated_at' => $this->convertDate($model->news_last_update, $created),
            ]);

            Upgrade::firstOrCreate([
                'type' => 'news-item',
                'old_id' => $model->news_id,
                'new_id' => $newsId,
            ]);
        });
    }

    /** @param LegacyNewsItem $model */
    public function asJob(object $model): void
    {
        $this->handle(
            model: $model,
            users: null
        );
    }
}
