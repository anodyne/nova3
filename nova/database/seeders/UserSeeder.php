<?php

namespace Database\Seeders;

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        activity()->disableLogging();

        $admin = User::factory()->active()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $admin->attachRoles(['admin', 'user']);

        $activeUser = User::factory()
            ->active()
            ->withUnverifiedEmail()
            ->create([
                'name' => 'user',
                'email' => 'user@user.com',
            ]);
        $activeUser->attachRole('user');

        User::factory()
            ->inactive()
            ->create([
                'name' => 'inactive',
                'email' => 'inactive@inactive.com',
            ]);

        activity()->enableLogging();
    }
}
