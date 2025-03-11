<x-modal.slide-over
    title="Post summary"
    description="If your post contains content intended only for mature audiences or that could be difficult for some people to read, you can provide a summary of the post."
    icon="blockquote"
>
    <x-form action="">
        <x-fieldset.field-group>
            <x-fieldset.field label="Summary" id="summary" name="summary">
                <x-input.textarea wire:model.blur="summary" rows="15"></x-input.textarea>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-form>

    <x-slot name="footer">
        <x-button wire:click="save" color="primary">Save</x-button>
        <x-button wire:click="$dispatch('slide-over.close')" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
