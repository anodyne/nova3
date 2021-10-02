<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Nova\Roles\Models\Permission;

class AddPermissionsModal extends ModalComponent
{
    public Collection $allPermissions;

    public string $search = '';

    public array $selected = [];

    /**
     * Get the display name of a given permission.
     */
    public function permissionDisplayName($id): string
    {
        return $this->allPermissions->firstWhere('id', $id)->display_name;
    }

    /**
     * Apply the the selected permissions to the role.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'roles:manage-permissions' => ['permissionsSelected', [$this->selected]],
        ]);
    }

    /**
     * Dismiss the modal.
     */
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    /**
     * Get a subset of all permissions based on the search.
     */
    public function getFilteredPermissionsProperty(): Collection
    {
        $permissions = $this->search === '*'
            ? $this->allPermissions
            : $this->allPermissions
                ->filter(function ($permission) {
                    return Str::of($permission->name)->contains($this->search)
                        || Str::of($permission->display_name)->contains($this->search)
                        || Str::of($permission->description)->contains($this->search);
                });

        return $permissions->filter(fn ($p) => ! in_array($p->id, $this->selected));
    }

    public function mount()
    {
        $this->allPermissions = Permission::get();
    }

    public function render()
    {
        return view('livewire.roles.add-permissions-modal', [
            'filteredPermissions' => $this->filteredPermissions,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
