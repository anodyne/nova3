<x-modal.slide-over
    title="Post summary"
    description="If your post contains content intended only for mature audiences or that could be difficult for some people to read, you can provide a summary of the post."
    :icon="Tabler::Blockquote"
>
    <x-form action="">
        <x-fieldset.group>
            <x-textarea label="Summary" name="summary" wire:model.blur="summary" rows="15"></x-textarea>
        </x-fieldset.group>
    </x-form>

    <x-slot name="footer">
        <x-button wire:click="save" variant="primary">Save</x-button>
        <x-button wire:click="$dispatch('slide-over.close')" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
