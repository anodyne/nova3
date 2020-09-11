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
                class="cursor-pointer inline-flex items-center border uppercase tracking-wide font-semibold rounded-md transition ease-in-out duration-150 focus:outline-none border-gray-300 text-gray-700 bg-white hover:text-gray-500 active:text-gray-800 active:bg-gray-50 px-2.5 py-1.5 text-xs"
                x-bind:class="{ 'border-blue-300 shadow-outline-blue': focused }"
            >
                Change
            </label>
            <input type="hidden" name="avatar_path" wire:model="path">
        </span>
    </div>

    @error('avatar')
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-red-600 space-x-2" role="alert">
            @icon('alert', 'h-5 w-5 flex-shrink-0 text-red-400')
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
