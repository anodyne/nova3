<?php

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;

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

        $admin = factory(User::class)->create([
            'email' => 'admin@admin.com',
        ]);

        $admin->attachRole('admin');

        $user = factory(User::class)
            ->states('unverified-email')
            ->create([
                'email' => 'user@user.com',
            ]);

        $user->attachRole('user');

        activity()->enableLogging();
    }
}
