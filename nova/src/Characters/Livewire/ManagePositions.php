<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

/**
 * @property-read string $assignedPositions
 * @property-read Collection $models
 * @property-read Collection $positions
 */
class ManagePositions extends Component
{
    /** @var Collection<int, Position> */
    public Collection $assigned;

    public ?Character $character = null;

    public ?string $selected = null;

    #[Computed]
    public function assignedPositions(): string
    {
        return $this->assigned
            ->map(fn (Position $position) => $position->id)
            ->join(',');
    }

    /**
     * @return Collection<int, Position>
     */
    #[Computed]
    public function models(): Collection
    {
        /** @var User $user */
        $user = Auth::user();

        return Position::query()
            ->select(['id', 'department_id', 'available', 'name', 'status'])
            ->unless($user->can('create', Character::class), fn (Builder $query) => $query->where('available', '>', 0))
            ->get();
    }

    public function mount(): void
    {
        $this->assigned = $this->character->positions ?? Collection::make();
    }

    /**
     * @return Collection<int, Position>
     */
    #[Computed]
    public function positions(): Collection
    {
        return $this->assigned;
    }

    public function remove(Position $position): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Position $collectionPosition): bool => $collectionPosition->id === $position->id
        );

        $this->dispatch('positions-updated', positions: $this->assigned->pluck('id')->all());
    }

    public function render(): Factory|View
    {
        return view('pages.characters.livewire.manage-positions', [
            'assignedPositions' => $this->assignedPositions,
            'models' => $this->models,
            'positions' => $this->positions,
        ]);
    }

    public function updatedSelected(Position $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
    }
}
