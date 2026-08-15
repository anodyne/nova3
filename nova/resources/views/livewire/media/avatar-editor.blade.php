<x-modal :size-class="$this->sizeClass()" title="Crop photo" :icon="Tabler::Crop" x-data="cropper">
    <div>
        <div class="truecropper">
            <img src="{{ $temporaryUrl }}" x-ref="image" class="w-full max-w-full" />
        </div>

        <input type="file" x-ref="fileInput" wire:model="croppedImage" class="hidden" />

        @error('croppedImage')
            <x-description.danger>{{ $message }}</x-description.danger>
        @enderror
    </div>

    <x-slot name="footer">
        <x-button type="button" x-on:click="cropImage" variant="primary">
            Crop
            <div wire:loading wire:target="croppedImage" x-transition.opacity>
                <flux:icon.loading class="size-4" />
            </div>
        </x-button>
        <x-button type="button" wire:click="$dispatch('modal-close')" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal>
