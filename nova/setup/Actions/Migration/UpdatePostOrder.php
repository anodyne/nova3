<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePostOrder
{
    use AsAction;

    public function handle(): void
    {
        $driver = DB::getDriverName();
        $prefix = DB::getTablePrefix();

        if ($driver === 'mysql') {
            DB::statement("
                WITH ranked_posts AS (
                    SELECT
                        id,
                        ROW_NUMBER() OVER (
                            PARTITION BY story_id
                            ORDER BY published_at IS NULL ASC, published_at ASC
                        ) AS row_num
                    FROM {$prefix}posts
                )
                UPDATE {$prefix}posts
                JOIN ranked_posts ON {$prefix}posts.id = ranked_posts.id
                SET {$prefix}posts.order_column = ranked_posts.row_num
            ");
        } elseif ($driver === 'pgsql') {
            DB::statement("
                WITH ranked_posts AS (
                    SELECT
                        id,
                        ROW_NUMBER() OVER (
                            PARTITION BY story_id
                            ORDER BY published_at ASC NULLS LAST
                        ) AS row_num
                    FROM {$prefix}posts
                )
                UPDATE {$prefix}posts
                SET order_column = ranked_posts.row_num
                FROM ranked_posts
                WHERE {$prefix}posts.id = ranked_posts.id
            ");
        }
    }

    public function asJob(): void
    {
        $this->handle();
    }
}
