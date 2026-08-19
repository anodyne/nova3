<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $form = Form::key('userBio')->first();
        $password = 'secret';

        $admin = User::factory()->active()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => $password,
        ]);
        $admin->addRoles(['owner', 'admin', 'active', 'writer', 'story-manager', 'webmaster']);
        UpdateApplicationReviewers::run(ApplicationReviewers::from(globalReviewers: [$admin->id]));
        CreateFormSubmission::run($form, $admin);
        StartOnboarding::run(OnboardingProcess::NewUser, $admin);

        $actives = User::factory()
            ->count(15)
            ->active()
            ->sequence(fn ($seq): array => ['email' => 'user'.($seq->index + 1).'@user.com', 'password' => $password])
            ->create();

        $actives->each(function ($user) use ($form): void {
            $user->addRoles(['active', 'writer']);
            CreateFormSubmission::run($form, $user);
            StartOnboarding::run(OnboardingProcess::NewUser, $user);
        });

        $inactive = User::factory()->inactive()->create([
            'name' => 'inactive',
            'email' => 'inactive@inactive.com',
            'password' => $password,
            'created_at' => now()->subSeconds(2),
            'updated_at' => now()->subSeconds(2),
        ]);
        CreateFormSubmission::run($form, $inactive);
        TrackStatusUpdate::run($inactive);

        activity()->enableLogging();
    }
}
