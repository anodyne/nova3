<div class="flex flex-col">
    <div class="flex items-center">
        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </span>
        <span class="ml-5">
            <input type="file" wire:model="avatar">
            <input type="hidden" name="avatar_path" wire:model="path">
        </span>
    </div>

    @error('avatar')
        <div class="field-error" role="alert">
            @icon('alert')
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>
