<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Settings\Actions\UpdateApplicationReviewers;
use Nova\Settings\Data\ApplicationReviewers;
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

        $form = Form::key('userBio')->first();

        $admin = User::factory()->active()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $admin->addRoles(['owner', 'admin', 'active', 'writer', 'story-manager', 'webmaster']);
        UpdateApplicationReviewers::run(ApplicationReviewers::from(
            globalReviewers: [$admin->id],
        ));
        CreateFormSubmission::run($form, $admin);
        StartOnboarding::run(OnboardingProcess::NewUser, $admin);

        for ($i = 1; $i <= 15; $i++) {
            $activeUser = User::factory()
                ->active()
                ->create([
                    'email' => "user{$i}@user.com",
                ]);
            $activeUser->addRoles(['active', 'writer']);
            CreateFormSubmission::run($form, $activeUser);
            StartOnboarding::run(OnboardingProcess::NewUser, $activeUser);
        }

        $inactiveUser = User::factory()
            ->inactive()
            ->create([
                'name' => 'inactive',
                'email' => 'inactive@inactive.com',
            ]);
        CreateFormSubmission::run($form, $inactiveUser);
        sleep(2);
        TrackStatusUpdate::run($inactiveUser);

        // foreach (['p', 'ps', 'pu', 'psu', 's', 'su', 'u'] as $item) {
        //     $user = User::factory()->active()->create([
        //         'name' => "user_{$item}",
        //         'email' => "user_{$item}@user.com",
        //     ]);

        //     $str = str($item);

        //     match (true) {
        //         $str->contains('p') => $user->addRole('create-primary-characters'),
        //         $str->contains('s') => $user->addRole('create-secondary-characters'),
        //         $str->contains('u') => $user->addRole('create-support-characters'),
        //         default => $user,
        //     };

        //     CreateFormSubmission::run($form, $user);
        // }

        activity()->enableLogging();
    }
}
