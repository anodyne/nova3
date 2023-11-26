<x-dropdown placement="bottom-end">
    <x-slot name="emptyTrigger">
        <x-button.outlined color="danger">Delete my account</x-button.outlined>
    </x-slot>

    <x-dropdown.group>
        <x-dropdown.text>
            Are you sure you want to delete your account? This action is permanent and cannot be undone.
        </x-dropdown.text>
    </x-dropdown.group>
    <x-dropdown.group>
        <x-dropdown.item-danger type="button" icon="trash" wire:click="delete">Delete</x-dropdown.item-danger>
        <x-dropdown.item type="button" icon="prohibited" x-on:click.prevent="$dispatch('dropdown-close')">
            Cancel
        </x-dropdown.item>
    </x-dropdown.group>
</x-dropdown>
