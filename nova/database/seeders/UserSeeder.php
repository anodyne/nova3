<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Users\Models\User;

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
            ->unverifiedEmail()
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
