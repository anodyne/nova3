<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
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

        $form = Form::key('user')->first();

        $admin = User::factory()->active()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $admin->addRoles(['owner', 'admin', 'active', 'writer', 'story-manager']);
        PopulateAccountPreferences::run($admin);
        PopulateNotificationPreferences::run($admin);
        CreateFormSubmission::run($form, $admin);

        for ($i = 1; $i <= 5; $i++) {
            $activeUser = User::factory()
                ->active()
                ->create([
                    'name' => 'user'.$i,
                    'email' => "user{$i}@user.com",
                ]);
            $activeUser->addRoles(['active', 'writer']);
            PopulateAccountPreferences::run($activeUser);
            PopulateNotificationPreferences::run($activeUser);
            CreateFormSubmission::run($form, $activeUser);
        }

        $inactiveUser = User::factory()
            ->inactive()
            ->create([
                'name' => 'inactive',
                'email' => 'inactive@inactive.com',
            ]);
        $inactiveUser->addRoles(['inactive']);
        PopulateAccountPreferences::run($inactiveUser);
        PopulateNotificationPreferences::run($inactiveUser);
        CreateFormSubmission::run($form, $inactiveUser);

        $pendingUser = User::factory()
            ->pending()
            ->create([
                'name' => 'pending',
                'email' => 'pending@pending.com',
            ]);
        $pendingUser->addRoles(['inactive']);
        PopulateAccountPreferences::run($pendingUser);
        PopulateNotificationPreferences::run($pendingUser);
        CreateFormSubmission::run($form, $pendingUser);

        foreach (['p', 'ps', 'pu', 'psu', 's', 'su', 'u'] as $item) {
            $user = User::factory()->active()->create([
                'name' => "user_{$item}",
                'email' => "user_{$item}@user.com",
            ]);

            $str = str($item);

            match (true) {
                $str->contains('p') => $user->addRole('create-primary-characters'),
                $str->contains('s') => $user->addRole('create-secondary-characters'),
                $str->contains('u') => $user->addRole('create-support-characters'),
                default => $user,
            };

            PopulateAccountPreferences::run($user);
            PopulateNotificationPreferences::run($user);
            CreateFormSubmission::run($form, $user);
        }

        activity()->enableLogging();
    }
}
