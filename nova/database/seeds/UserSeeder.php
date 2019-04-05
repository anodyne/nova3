<?php

use Nova\Users\User;
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
        $admin = factory(User::class)->create([
            'email' => 'admin@admin.com',
        ]);

        $admin->assign('admin');

        $user = factory(User::class)
            ->states('unverified-email')
            ->create([
                'email' => 'user@user.com',
            ]);

        $user->assign('user');
    }
}
