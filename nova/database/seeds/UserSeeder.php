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
        ])->attachRole('admin');

        $user = factory(User::class)
            ->states('unverified-email')
            ->create([
                'name' => 'user',
                'email' => 'user@user.com',
            ])->attachRole('user');

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
