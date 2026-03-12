<flux:pillbox
    name="assigned_permissions"
    placeholder="Choose permissions"
    wire:model.live="assigned"
    multiple
    searchable
>
    @foreach ($permissions as $permission)
        <flux:pillbox.option :value="$permission->id">
            {{ $permission->display_name }}
        </flux:pillbox.option>
    @endforeach
</flux:pillbox>
