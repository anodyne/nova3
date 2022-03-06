<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

class NoteSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        User::get()->each(
            fn ($user) => Note::factory()->count(5)->create([
                'user_id' => $user->id,
            ])
        );

        activity()->enableLogging();
    }
}
