<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Nova\Users\Enums\Appearance;
use Nova\Users\Models\User;

class AdminAppearance extends Component
{
    public Appearance $appearance;

    public function updatedAppearance($value): void
    {
        /** @var User $user */
        $user = Auth::user();

        $userPreferences = $user->preferences->with(appearance: $this->appearance);

        $user->update(['preferences' => $userPreferences]);

        $this->js('window.location.reload()');
    }

    public function mount(): void
    {
        $this->appearance = Auth::user()->preferences->appearance;
    }

    public function render(): Factory|View
    {
        return view('pages.users.livewire.admin-appearance');
    }
}
