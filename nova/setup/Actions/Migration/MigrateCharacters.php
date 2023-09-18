<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\Date;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Active;
use Nova\Characters\Models\States\Inactive;
use Nova\Characters\Models\States\Pending;
use Nova\Setup\Models\Legacy\Character as LegacyCharacter;
use Nova\Setup\Models\Legacy\User as LegacyUser;
use Nova\Setup\Models\Upgrade;

class MigrateCharacters
{
    use AsAction;

    public function handle(): void
    {
        LegacyCharacter::query()
            ->cursor()
            ->each(function (LegacyCharacter $legacyChar) {
                $isMainCharacter = LegacyUser::where('main_char', $legacyChar->charid)->count();

                $character = Character::create([
                    'name' => collect([$legacyChar->first_name, $legacyChar->middle_name, $legacyChar->last_name, $legacyChar->suffix])
                        ->filter()
                        ->join(' '),
                    'email' => $legacyChar->email,
                    'status' => match ($legacyChar->crew_type) {
                        'inactive' => Inactive::class,
                        'pending' => Pending::class,
                        default => Active::class,
                    },
                    'type' => match (true) {
                        $legacyChar->user !== null => CharacterType::secondary,
                        $isMainCharacter => CharacterType::primary,
                        default => CharacterType::support,
                    },
                    'force_password_reset' => true,
                    'created_at' => $date = $legacyChar->join_date ? Date::createFromTimestamp($legacyChar->join_date) : null,
                    'updated_at' => $legacyChar->last_update ? Date::createFromTimestamp($legacyChar->last_update) : $date,
                ]);

                Upgrade::create([
                    'type' => 'user',
                    'old_id' => $legacyChar->userid,
                    'new_id' => $character->id,
                ]);
            });
    }
}
