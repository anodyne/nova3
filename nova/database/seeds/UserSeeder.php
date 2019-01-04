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
        factory(User::class)->create([
            'email' => 'admin@admin.com',
        ]);

        factory(User::class)
            ->states('unverified-email')
            ->create([
                'email' => 'user@user.com',
            ]);
    }
}
