<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class CharactersManifest extends Component
{
    public string $layout = 'table';

    public bool $showCharacters = false;

    public bool $showDepartments = false;

    public bool $showPositions = false;

    public bool $showAvailablePositions = false;

    public array $columns = [];

    public array $characterOptions = [];

    public ?string $cardOrientation = 'center';

    public ?string $departmentStatus = null;

    public array $selectedDepartments = [];

    public ?string $positionStatus = null;

    public array $selectedPositions = [];

    public ?string $characterStatus = null;

    public ?string $characterType = null;

    public ?string $availablePositionsStatus = null;

    public array $selectedAvailablePositions = [];

    #[Computed]
    public function characters(): ?Collection
    {
        if (! $this->showCharacters) {
            return null;
        }

        return Character::with('positions', 'rank.name')
            ->when($this->characterStatus === 'all', fn ($query) => $query->notPending())
            ->when($this->characterStatus === 'active', fn ($query) => $query->active())
            ->when($this->characterStatus === 'inactive', fn ($query) => $query->inactive())
            ->when($this->characterType === 'primary', fn ($query) => $query->primary())
            ->when($this->characterType === 'secondary', fn ($query) => $query->secondary())
            ->when($this->characterType === 'support', fn ($query) => $query->support())
            ->when($this->characterType === 'primary-secondary', fn ($query) => $query->notSupport())
            ->when($this->characterType === 'primary-support', fn ($query) => $query->notSecondary())
            ->when($this->characterType === 'secondary-support', fn ($query) => $query->notPrimary())
            ->get();
    }

    #[Computed]
    public function departments(): ?Collection
    {
        if (! $this->showDepartments) {
            return null;
        }

        return Department::query()
            ->with([
                // 'positions' => fn ($query) => $query->whereHas('characters'),
                'positions.characters.rank.name',
            ])
            ->when($this->departmentStatus === 'active', fn ($dQuery) => $dQuery->active())
            ->when($this->departmentStatus === 'inactive', fn ($dQuery) => $dQuery->inactive())
            ->when($this->departmentStatus === 'choose', fn ($dQuery) => $dQuery->whereIn('id', $this->selectedDepartments))
            ->whereHas('positions', function ($query) {
                return $query
                    ->when($this->positionStatus === 'active', fn ($pQuery) => $pQuery->active())
                    ->when($this->positionStatus === 'inactive', fn ($pQuery) => $pQuery->inactive())
                    ->when($this->positionStatus === 'choose', fn ($pQuery) => $pQuery->whereIn('id', $this->selectedPositions))
                    ->when($this->showCharacters === true && $this->showAvailablePositions === false, function ($query) {
                        return $query->whereHas('characters', function ($query) {
                            return $query
                                ->when($this->characterStatus === 'all', fn ($cQuery) => $cQuery->notPending())
                                ->when($this->characterStatus === 'active', fn ($cQuery) => $cQuery->active())
                                ->when($this->characterStatus === 'inactive', fn ($cQuery) => $cQuery->inactive())
                                ->when($this->characterType === 'primary', fn ($cQuery) => $cQuery->primary())
                                ->when($this->characterType === 'secondary', fn ($cQuery) => $cQuery->secondary())
                                ->when($this->characterType === 'support', fn ($cQuery) => $cQuery->support())
                                ->when($this->characterType === 'primary-secondary', fn ($cQuery) => $cQuery->notSupport())
                                ->when($this->characterType === 'primary-support', fn ($cQuery) => $cQuery->notSecondary())
                                ->when($this->characterType === 'secondary-support', fn ($cQuery) => $cQuery->notPrimary());
                        });
                    });
            })
            ->get();
    }

    #[Computed]
    public function positions(): ?Collection
    {
        if (! $this->showAvailablePositions) {
            return null;
        }

        return Position::available()
            ->when($this->availablePositionsStatus === 'choose', fn ($q) => $q->whereIn('id', $this->selectedAvailablePositions))
            ->get();
    }

    public function shouldShowAvailablePosition(Position $position): bool
    {
        return $this->showAvailablePositions
            && $position->available > 0
            && $position->status === PositionStatus::active
            && (
                $this->availablePositionsStatus === 'all' ||
                ($this->availablePositionsStatus === 'choose' && in_array($position->id, $this->selectedAvailablePositions))
            );
    }

    public function render()
    {
        return view('pages.pages.livewire.characters-manifest', [
            'characters' => $this->characters,
            'departments' => $this->departments,
            'positions' => $this->positions,
        ]);
    }
}
