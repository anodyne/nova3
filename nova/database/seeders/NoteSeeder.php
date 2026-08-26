<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $now = Date::now()->setMicrosecond(0)->toDateTimeString();

        $userIds = User::query()->pluck('id')->all();

        $notes = [];
        foreach ($userIds as $userId) {
            $batch = Note::factory()
                ->count(5)
                ->make([
                    'user_id' => $userId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
                ->map(fn ($note): array => array_replace($note->getAttributes(), [
                    'id' => Str::uuid7()->toString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]))
                ->all();

            $notes = array_merge($notes, $batch);
        }

        collect($notes)
            ->chunk(1000)
            ->each(fn ($chunk) => Note::insert($chunk->toArray()));

        activity()->enableLogging();
    }
}
