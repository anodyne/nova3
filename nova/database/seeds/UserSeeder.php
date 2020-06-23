<?php

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

        $admin = factory(User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $admin->status->transitionTo(Active::class);
        $admin->attachRoles(['admin', 'user']);

        $activeUser = factory(User::class)
            ->states('unverified-email')
            ->create([
                'name' => 'user',
                'email' => 'user@user.com',
            ]);
        $activeUser->status->transitionTo(Active::class);
        $activeUser->attachRole('user');

        $inactiveUser = factory(User::class)
            ->create([
                'name' => 'inactive',
                'email' => 'inactive@inactive.com',
            ]);
        $inactiveUser->status->transitionTo(Inactive::class);

        factory(User::class)->times(25)->create()->each(function ($user) {
            $decision = mt_rand(1, 3);

            $user->attachRole('user');

            if ($decision === 2) {
                $user->status->transitionTo(Active::class);
            }

            if ($decision === 3) {
                $user->status->transitionTo(Active::class);
                $user->status->transitionTo(Inactive::class);
            }
        });

        activity()->enableLogging();
    }
}
