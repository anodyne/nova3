<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Settings\Actions\UpdateApplicationReviewers;
use Nova\Settings\Data\ApplicationReviewers;
use Nova\Setup\Enums\SetupType;
use Nova\Users\Models\User;

#[Layout('layouts.setup', ['type' => SetupType::Migrate])]
class UserAccess extends Component
{
    public ?string $userId = null;

    public function setAccess()
    {
        if (filled($this->userId)) {
            $user = User::findOrFail($this->userId);

            $user->addRoles(['owner', 'admin', 'active', 'writer', 'story-manager', 'webmaster']);

            UpdateApplicationReviewers::run(ApplicationReviewers::from(
                globalReviewers: [$user->id],
            ));

            StartOnboarding::run(OnboardingProcess::NovaMigration, $user);

            StartOnboarding::run(OnboardingProcess::NewUser, $user);

            Cache::put('migration_account_setup_complete', true, now()->addHour());

            $this->redirect('/setup/migrate');
        }
    }

    public function render()
    {
        return view('setup.migrate-nova.user-access', [
            'users' => $this->users,
        ]);
    }

    #[Computed]
    public function users(): Collection
    {
        return User::active()->get();
    }
}
