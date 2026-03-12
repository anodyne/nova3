<div>
    <x-button type="button" wire:click="openForEditing" variant="ghost">
        {{ filled($summary) ? 'Update' : 'Add' }}
        summary
        <span aria-hidden="true">→</span>
    </x-button>
</div>
