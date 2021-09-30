<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Nova\Roles\Models\Permission;

class AddPermissionsModal extends ModalComponent
{
    public Collection $filteredPermissions;

    public Collection $permissions;

    public ?Collection $results;

    public string $search = '';

    public array $selected = [1];

    public function permissionDisplayName($id): string
    {
        return $this->permissions->where('id', $id)->first()->display_name;
    }

    public function selectPermission($permissionId): void
    {
        $this->closeModalWithEvents([
            'roles:manage-permissions' => ['permissionSelected', [$permissionId]],
        ]);
    }

    public function updatedSearch($value)
    {
        $this->filteredPermissions = $this->permissions->filter(function ($permission) use ($value) {
            return Str::of($permission->name)->contains($value)
                || Str::of($permission->display_name)->contains($value)
                || Str::of($permission->description)->contains($value);
        })->filter(function ($permission) {
            return ! in_array($permission->id, $this->selected);
        });

        // $this->results = Permission::query()
        //     ->where(function ($query) use ($value) {
        //         return $query->where('name', 'like', "%{$value}%")
        //             ->orWhere('display_name', 'like', "%{$value}%")
        //             ->orWhere('description', 'like', "%{$value}%");
        //     })
        //     // ->whereNotIn('id', $this->role->permissions->map(fn ($permission) => $permission->id)->all())
        //     ->get();
    }

    public function mount()
    {
        $this->permissions = Permission::get();
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
