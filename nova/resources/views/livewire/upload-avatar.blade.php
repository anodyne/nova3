<div class="flex flex-col">
    <div class="flex items-center space-x-5">
        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
            @if ($avatar)
                <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar">
            @else
                @if ($existingAvatar)
                    <img src="{{ $existingAvatar }}" alt="Avatar">
                @else
                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                @endif
            @endif
        </span>
        <span x-data="{ focused: false }">
            <input x-on:focus="focused = true" x-on:blur="focused = false" type="file" id="avatar" wire:model="avatar" class="sr-only">
            <label
                for="avatar"
                class="cursor-pointer py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"
                x-bind:class="{ 'outline-none border-blue-300 shadow-outline-blue': focused }"
            >
                Change
            </label>
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
