<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyApplication object{
 *     app_character: int|null,
 *     app_user: int|null,
 *     app_ip: string|null,
 *     app_action: string,
 *     app_message: string|null,
 *     app_date: int|null,
 *     app_id: int
 * }
 */
class MigrateApplication
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    /**
     * @param  LegacyApplication  $model
     * @param  Collection<int, object>|null  $characters
     * @param  Collection<int, object>|null  $users
     */
    public function handle(object $model, ?Collection $characters, ?Collection $users): void
    {
        $newCharacterId = $this->getNewId(
            id: $model->app_character,
            collection: $characters,
            upgradeKey: 'character'
        );

        $newUserId = $this->getNewId(
            id: $model->app_user,
            collection: $users,
            upgradeKey: 'user'
        );

        DB::transaction(function () use ($model, $newCharacterId, $newUserId): void {
            $applicationId = DB::table('applications')->insertGetId([
                'user_id' => $newUserId,
                'character_id' => $newCharacterId,
                'ip_address' => $model->app_ip,
                'result' => match ($model->app_action) {
                    'accepted' => ApplicationResult::Accept->value,
                    'rejected' => ApplicationResult::Deny->value,
                    default => ApplicationResult::Pending->value,
                },
                'decision_message' => $model->app_message,
                'decision_date' => $date = $this->convertDate($model->app_date),
                'created_at' => $created = $date ?? now('UTC'),
                'updated_at' => $created,
            ]);

            Upgrade::firstOrCreate([
                'type' => 'application',
                'old_id' => $model->app_id,
                'new_id' => $applicationId,
            ]);
        });
    }

    /** @param LegacyApplication $model */
    public function asJob(object $model): void
    {
        $this->handle(
            model: $model,
            characters: null,
            users: null
        );
    }
}
