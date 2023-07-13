<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

class ManageOwnership extends Component
{
    public bool $linkToUser = false;

    public bool $assignAsPrimary = false;

    public function getHasReachedCharacterLimitProperty(): bool
    {
        return settings('characters.enforceCharacterLimits') &&
            auth()->user()->activeCharacters()->count() >= settings('characters.characterLimit');
    }

    public function getCharacterStatusProperty(): array
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

    public function getCharacterTypeProperty(): CharacterType
    {
        if ($this->assignAsPrimary) {
            return CharacterType::primary;
        }

        if ($this->linkToUser) {
            return CharacterType::secondary;
        }

        return CharacterType::support;
    }

    public function getLinkToUserValueProperty(): bool
    {
        $user = auth()->user();

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

    public function getLinkToUserDisabledProperty(): bool
    {
        $user = auth()->user();

        if (
            $user->canAny(['createSecondary', 'createPrimary'], Character::class) &&
            $user->cannot('createSupport', Character::class)
        ) {
            return true;
        }

        return auth()->user()->cannot('selfAssign', Character::class);
    }

    public function getAssignAsPrimaryValueProperty(): bool
    {
        $user = auth()->user();

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

    public function updatedAssignAsPrimary($value)
    {
        $user = auth()->user();

        if (
            $user->can('createPrimary', Character::class) &&
            $user->can('createSecondary', Character::class) &&
            $this->linkToUser === false &&
            (bool) $value === true
        ) {
            $this->assignAsPrimary = (bool) $value;
            $this->linkToUser = (bool) $value;
        }
    }

    public function updatedLinkToUser($value)
    {
        $user = auth()->user();

        if (
            $user->can('createPrimary', Character::class) &&
            $user->cannot('createSecondary', Character::class) &&
            $user->can('createSupport', Character::class)
        ) {
            $this->assignAsPrimary = (bool) $value;
        }
    }

    public function mount()
    {
        $this->linkToUser = $this->linkToUserValue;
        $this->assignAsPrimary = $this->assignAsPrimaryValue;
    }

    public function render()
    {
        return view('livewire.characters.manage-ownership', [
            'hasReachedCharacterLimit' => $this->hasReachedCharacterLimit,
            'characterStatus' => $this->characterStatus,
            'characterType' => $this->characterType,
            'linkToUserDisabled' => $this->linkToUserDisabled,
        ]);
    }
}
