<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Nova\Roles\Models\Permission;

class AddPermissionsModal extends ModalComponent
{
    public ?Collection $allPermissions;

    public ?Collection $filteredPermissions;

    public string $search = '';

    public array $selected = [];

    public function permissionDisplayName($id): string
    {
        return $this->allPermissions->where('id', $id)->first()->display_name;
    }

    public function apply(): void
    {
        $this->closeModalWithEvents([
            'roles:manage-permissions' => ['permissionsSelected', [$this->selected]],
        ]);
    }

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function resetSearch(): void
    {
        $this->search = '';
        $this->filteredPermissions = null;
    }

    public function updatedSearch($value)
    {
        $this->filteredPermissions = $this->allPermissions->filter(function ($permission) use ($value) {
            return Str::of($permission->name)->contains($value)
                || Str::of($permission->display_name)->contains($value)
                || Str::of($permission->description)->contains($value);
        })->filter(function ($permission) {
            return ! in_array($permission->id, $this->selected);
        });
    }

    public function mount()
    {
        $this->allPermissions = Permission::get();
    }

    public function render()
    {
        return view('livewire.roles.add-permissions-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
