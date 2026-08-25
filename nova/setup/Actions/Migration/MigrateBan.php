<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyBan object{
 *     ban_email: string,
 *     ban_ip: string|null,
 *     ban_reason: string|null,
 *     ban_date: int|null,
 *     ban_id: int
 * }
 */
class MigrateBan
{
    use AsAction;
    use HandlesDates;

    /** @param LegacyBan $model */
    public function handle(object $model): void
    {
        DB::transaction(function () use ($model): void {
            $existingUser = DB::connection('nova2')
                ->table('users')
                ->where('email', $model->ban_email)
                ->first();

            $banId = DB::table('bans')->insertGetId([
                'bannable_type' => $existingUser ? 'user' : null,
                'bannable_id' => $existingUser?->id,
                'ip' => blank($existingUser) ? $model->ban_ip : null,
                'comment' => $model->ban_reason,
                'metas' => filled($model->ban_email)
                    ? json_encode(['email' => $model->ban_email])
                    : null,
                'created_at' => $created = $this->convertDate($model->ban_date, now('UTC')),
                'updated_at' => $created,
            ]);

            Upgrade::firstOrCreate([
                'type' => 'ban',
                'old_id' => $model->ban_id,
                'new_id' => $banId,
            ]);
        });
    }

    /** @param LegacyBan $model */
    public function asJob(object $model): void
    {
        $this->handle($model);
    }
}
