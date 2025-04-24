<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Onboarding\Enums\OnboardingProcess;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    protected bool $async = false;

    protected string $queue = 'default';

    protected ?string $tag = null;

    public function process(): void
    {
        $this->createNovaInstalledOnboardingProcess();

        $this->createNovaMigratedOnboardingProcess();

        $this->createNewUserOnboardingProcess();
    }

    protected function createNovaInstalledOnboardingProcess(): void
    {
        $processId = DB::table('onboarding')->insertGetId([
            'name' => 'Nova fresh install',
            'key' => OnboardingProcess::FreshInstall->value,
            'description' => '',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }

    protected function createNovaMigratedOnboardingProcess(): void
    {
        $processId = DB::table('onboarding')->insertGetId([
            'name' => 'Nova 2 migration',
            'key' => OnboardingProcess::NovaMigration->value,
            'description' => '',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }

    protected function createNewUserOnboardingProcess(): void
    {
        $newUserId = DB::table('onboarding')->insertGetId([
            'name' => 'New user',
            'key' => OnboardingProcess::NewUser->value,
            'description' => '',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
};
