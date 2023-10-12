<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Users\Data\PronounsData;
use Nova\Users\Models\User;

class SetupAccount extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public bool $isFinished = false;

    public function createUserAccount(): void
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'pronouns' => PronounsData::from(['value' => 'none']),
        ]);

        $user->addRoles(['owner', 'admin', 'active', 'writer', 'story-manager']);

        $user->refresh();

        Auth::login($user, remember: true);

        $this->isFinished = true;

        $this->dispatch('confetti');
    }

    #[Computed]
    public function shouldShowForm(): bool
    {
        return ! $this->isFinished;
    }

    #[Computed]
    public function shouldShowSuccessTable(): bool
    {
        return $this->isFinished;
    }

    public function mount()
    {
        if (User::count() > 0) {
            $this->isFinished = true;

            $this->dispatch('confetti');
        }
    }

    public function render()
    {
        return view('setup.account.index', [
            'shouldShowForm' => $this->shouldShowForm,
            'shouldShowSuccessTable' => $this->shouldShowSuccessTable,
        ])->layout('layouts.setup');
    }
}
