<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

/**
 * @property-read bool $hasReachedCharacterLimit
 * @property-read array<string, string> $characterStatus
 * @property-read CharacterType $characterType
 * @property-read bool $linkToUserValue
 * @property-read bool $linkToUserDisabled
 * @property-read bool $assignAsPrimaryValue
 */
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

    /**
     * @return array{color: string, label: string}
     */
    #[Computed]
    public function characterStatus(): array
    {
        if (
            ($this->characterType === CharacterType::Primary && settings('characters.approvePrimary')) ||
            ($this->characterType === CharacterType::Secondary && settings('characters.approveSecondary')) ||
            ($this->characterType === CharacterType::Support && settings('characters.approveSupport'))
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
            return CharacterType::Primary;
        }

        if ($this->linkToUser) {
            return CharacterType::Secondary;
        }

        return CharacterType::Support;
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

        return ! ($user->cannot('createPrimary', Character::class) && $user->can('createSecondary', Character::class) && $user->can('createSupport', Character::class));
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
            $this->assignAsPrimary
        ) {
            // TODO: test this scenario
            $this->linkToUser = $this->assignAsPrimary;
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
            $this->assignAsPrimary = $this->linkToUser;
        }
    }

    public function mount(): void
    {
        $this->linkToUser = $this->linkToUserValue;
        $this->assignAsPrimary = $this->assignAsPrimaryValue;
    }

    public function render(): Factory|View
    {
        return view('pages.characters.livewire.manage-ownership', [
            'hasReachedCharacterLimit' => $this->hasReachedCharacterLimit,
            'characterStatus' => $this->characterStatus,
            'characterType' => $this->characterType,
            'linkToUserDisabled' => $this->linkToUserDisabled,
        ]);
    }
}
