<flux:pillbox name="assigned_roles" placeholder="Choose roles" wire:model.live="assigned" multiple searchable>
    @foreach ($roles as $role)
        <flux:pillbox.option :value="$role->id">{{ $role->display_name }}</flux:pillbox.option>
    @endforeach
</flux:pillbox>
