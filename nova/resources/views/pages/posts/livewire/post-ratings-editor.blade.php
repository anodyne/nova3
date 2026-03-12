<x-modal.slide-over
    title="Update content ratings"
    description="Let players and readers know what to expect from your post by setting the content ratings. These content ratings follow the game’s default ratings unless you specify otherwise."
    :icon="Tabler::Rating18Plus"
>
    <x-form action="">
        <x-fieldset.group>
            <x-field>
                <x-label>Language</x-label>
                <livewire:rating area="language" wire:model.live="language" />
            </x-field>

            <x-field>
                <x-label>Sex</x-label>
                <livewire:rating area="sex" wire:model.live="sex" />
            </x-field>

            <x-field>
                <x-label>Violence</x-label>
                <livewire:rating area="violence" wire:model.live="violence" />
            </x-field>
        </x-fieldset.group>
    </x-form>

    <x-slot name="footer">
        <x-button wire:click="save" variant="primary">Save</x-button>
        <x-button wire:click="$dispatch('slide-over.close')" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
