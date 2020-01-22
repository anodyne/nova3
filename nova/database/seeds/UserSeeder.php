<?php

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;
use Nova\Users\Models\States\Active;

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

        $admin->transitionTo(Active::class)->attachRole('admin');

        $user = factory(User::class)
            ->states('unverified-email')
            ->create([
                'email' => 'user@user.com',
            ]);

        $user->transitionTo(Active::class)->attachRole('user');

        factory(User::class)->times(50)->create()->each->attachRole('user');

        activity()->enableLogging();
    }
}
