<div>
    <x-button type="button" wire:click="openForEditing" plain>
        {{ filled($summary) ? 'Update' : 'Add' }}
        summary &rarr;
    </x-button>
</div>
