<x-modal title="Crop photo" icon="crop" x-data="cropper">
    <div>
        <div class="truecropper">
            <img src="{{ $temporaryUrl }}" x-ref="image" class="w-full max-w-full" />
        </div>

        <input type="file" x-ref="fileInput" wire:model="croppedImage" class="hidden" />

        @error('croppedImage')
            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
        @enderror
    </div>

    <x-slot name="footer">
        <x-button type="button" x-on:click="cropImage" color="primary">
            Crop
            <div wire:loading wire:target="croppedImage" x-transition.opacity>
                <flux:icon.loading class="size-4" />
            </div>
        </x-button>
        <x-button type="button" wire:click="$dispatch('modal.close')" plain>Cancel</x-button>
    </x-slot>
</x-modal>
