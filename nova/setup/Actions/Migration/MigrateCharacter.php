<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Enums\CharacterType;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

class MigrateCharacter
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    public function handle(object $model, ?Collection $users, ?Collection $positions): void
    {
        $characterType = $this->getCharacterType($model->user, $model->charid);

        $newUserId = $this->getNewId(
            id: $model->user,
            collection: $users,
            upgradeKey: 'user'
        );

        $newFirstPositionId = $this->getNewId(
            id: $model->position_1,
            collection: $positions,
            upgradeKey: 'position'
        );

        $newSecondPositionId = $this->getNewId(
            id: $model->position_2,
            collection: $positions,
            upgradeKey: 'position'
        );

        DB::transaction(function () use ($model, $newUserId, $newFirstPositionId, $newSecondPositionId, $characterType): void {
            $characterId = DB::table('characters')->insertGetId([
                'name' => collect([$model->first_name, $model->middle_name, $model->last_name, $model->suffix])
                    ->filter()
                    ->join(' '),
                'status' => match ($model->crew_type) {
                    'npc' => 'active',
                    default => $model->crew_type,
                },
                'type' => $characterType,
                'created_at' => $date = $this->convertDate($model->date_activate, now('UTC')),
                'updated_at' => $date,
            ]);

            if (filled($model->date_activate) && $model->date_activate > 0) {
                DB::table('status_history')->insert([
                    'statusable_type' => 'character',
                    'statusable_id' => $characterId,
                    'status' => 'active',
                    'started_at' => $this->convertDate($model->date_activate),
                    'ended_at' => $this->convertDate($model->date_deactivate),
                ]);
            }

            if ($newUserId) {
                DB::table('character_user')->insert([
                    'character_id' => $characterId,
                    'user_id' => $newUserId,
                    'primary' => $characterType === CharacterType::Primary->value,
                ]);
            }

            if ($newFirstPositionId) {
                DB::table('character_position')->insert([
                    'character_id' => $characterId,
                    'position_id' => $newFirstPositionId,
                ]);
            }

            if ($newSecondPositionId) {
                DB::table('character_position')->insert([
                    'character_id' => $characterId,
                    'position_id' => $newSecondPositionId,
                ]);
            }

            Upgrade::firstOrCreate([
                'type' => 'character',
                'old_id' => $model->charid,
                'new_id' => $characterId,
            ]);
        });
    }

    public function asJob(object $model): void
    {
        $this->handle(
            model: $model,
            users: null,
            positions: null
        );
    }

    private function getCharacterType(?int $userId, int $characterId): string
    {
        $user = DB::connection('nova2')
            ->table('users')
            ->select('userid', 'main_char')
            ->where('userid', $userId)
            ->first();

        return match (true) {
            $user && $user->main_char === $characterId => CharacterType::Primary->value,
            $user && $user->main_char !== $characterId => CharacterType::Secondary->value,
            default => CharacterType::Support->value,
        };
    }
}
