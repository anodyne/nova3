<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

class ManagePositions extends Component
{
    public ?Character $character = null;

    public Collection $assigned;

    public ?string $selected = null;

    public function remove(Position $position): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Position $collectionPosition) => $collectionPosition->id === $position->id
        );

        $this->dispatch('positions-updated', positions: $this->assigned->pluck('id')->all());
    }

    public function updatedSelected(Position $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
    }

    public function mount(): void
    {
        $this->assigned = $this->character?->positions ?? Collection::make();
    }

    public function render()
    {
        return view('pages.characters.livewire.manage-positions', [
            'assignedPositions' => $this->assignedPositions,
            'models' => $this->models,
            'positions' => $this->positions,
        ]);
    }

    #[Computed]
    public function assignedPositions(): string
    {
        return $this->assigned
            ->map(fn (Position $position) => $position->id)
            ->join(',');
    }

    #[Computed]
    public function models(): Collection
    {
        /** @var User */
        $user = Auth::user();

        return Position::query()
            ->select(['id', 'department_id', 'available', 'name', 'status'])
            ->unless($user?->can('create', Character::class), fn (Builder $query) => $query->where('available', '>', 0))
            ->get();
    }

    #[Computed]
    public function positions(): Collection
    {
        return $this->assigned;
    }
}
