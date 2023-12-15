<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

class ManageOwnership extends Component
{
    public bool $linkToUser = false;

    public bool $assignAsPrimary = false;

    #[Computed]
    public function hasReachedCharacterLimit(): bool
    {
        return settings('characters.enforceCharacterLimits') &&
            Auth::user()->activeCharacters()->count() >= settings('characters.characterLimit');
    }

    #[Computed]
    public function characterStatus(): array
    {
        if (
            ($this->characterType === CharacterType::primary && settings('characters.approvePrimary')) ||
            ($this->characterType === CharacterType::secondary && settings('characters.approveSecondary')) ||
            ($this->characterType === CharacterType::support && settings('characters.approveSupport'))
        ) {
            return [
                'color' => 'warning',
                'label' => 'Pending',
            ];
        }

        return [
            'color' => 'success',
            'label' => 'Active',
        ];
    }

    #[Computed]
    public function characterType(): CharacterType
    {
        if ($this->assignAsPrimary) {
            return CharacterType::primary;
        }

        if ($this->linkToUser) {
            return CharacterType::secondary;
        }

        return CharacterType::support;
    }

    #[Computed]
    public function linkToUserValue(): bool
    {
        $user = Auth::user();

        if (
            $user->can('createPrimary', Character::class) &&
            $user->cannot('createSecondary', Character::class) &&
            $user->cannot('createSupport', Character::class)
        ) {
            return true;
        }

        if (
            $user->can('createPrimary', Character::class) &&
            $user->cannot('createSecondary', Character::class) &&
            $user->can('createSupport', Character::class)
        ) {
            return false;
        }

        if (
            $user->can('createPrimary', Character::class) &&
            $user->can('createSecondary', Character::class) &&
            $user->can('createSupport', Character::class)
        ) {
            return false;
        }

        if (
            $user->cannot('createPrimary', Character::class) &&
            $user->cannot('createSecondary', Character::class) &&
            $user->can('createSupport', Character::class)
        ) {
            return false;
        }

        if (
            $user->cannot('createPrimary', Character::class) &&
            $user->can('createSecondary', Character::class) &&
            $user->can('createSupport', Character::class)
        ) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function linkToUserDisabled(): bool
    {
        $user = Auth::user();

        if (
            $user->canAny(['createSecondary', 'createPrimary'], Character::class) &&
            $user->cannot('createSupport', Character::class)
        ) {
            return true;
        }

        return Auth::user()->cannot('selfAssign', Character::class);
    }

    #[Computed]
    public function assignAsPrimaryValue(): bool
    {
        $user = Auth::user();

        if (
            $user->can('createPrimary', Character::class) &&
            $user->can('createSupport', Character::class) &&
            $user->cannot('createSecondary', Character::class)
        ) {
            return false;
        }

        if (
            $user->can('createPrimary', Character::class) &&
            $user->cannot('createSecondary', Character::class)
        ) {
            return true;
        }

        if (
            $user->can('createPrimary', Character::class) &&
            $user->can('createSecondary', Character::class)
        ) {
            return false;
        }

        return $user->can('createPrimary', Character::class);
    }

    public function updatedAssignAsPrimary(): void
    {
        $user = Auth::user();

        if (
            $user->can('createPrimary', Character::class) &&
            $user->can('createSecondary', Character::class) &&
            $this->linkToUser === false &&
            (bool) $this->assignAsPrimary === true
        ) {
            // TODO: test this scenario
            $this->linkToUser = (bool) $this->assignAsPrimary;
        }
    }

    public function updatedLinkToUser(): void
    {
        $user = Auth::user();

        if (
            $user->can('createPrimary', Character::class) &&
            $user->cannot('createSecondary', Character::class) &&
            $user->can('createSupport', Character::class)
        ) {
            $this->assignAsPrimary = (bool) $this->linkToUser;
        }
    }

    public function mount()
    {
        $this->linkToUser = $this->linkToUserValue;
        $this->assignAsPrimary = $this->assignAsPrimaryValue;
    }

    public function render()
    {
        return view('pages.characters.livewire.manage-ownership', [
            'hasReachedCharacterLimit' => $this->hasReachedCharacterLimit,
            'characterStatus' => $this->characterStatus,
            'characterType' => $this->characterType,
            'linkToUserDisabled' => $this->linkToUserDisabled,
        ]);
    }
}
