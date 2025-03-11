<x-modal.slide-over
    title="Update content ratings"
    description="Let players and readers know what to expect from your post by setting the content ratings. These content ratings follow the game’s default ratings unless you specify otherwise."
    icon="mature"
>
    <x-form action="">
        <x-fieldset.field-group>
            <x-fieldset.field label="Language" id="language" name="language">
                <livewire:rating area="language" wire:model.live="language" />
            </x-fieldset.field>

            <x-fieldset.field label="Sex" id="sex" name="sex">
                <livewire:rating area="sex" wire:model.live="sex" />
            </x-fieldset.field>

            <x-fieldset.field label="Violence" id="violence" name="violence">
                <livewire:rating area="violence" wire:model.live="violence" />
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-form>

    <x-slot name="footer">
        <x-button wire:click="save" color="primary">Save</x-button>
        <x-button wire:click="$dispatch('slide-over.close')" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
