<div class="flex flex-col">
    <div class="flex items-center space-x-5">
        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
            @if ($avatar)
                <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar">
            @else
                @if ($existingAvatar)
                    <img src="{{ $existingAvatar }}" alt="Avatar">
                @else
                    <svg class="h-full w-full text-gray-9" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                @endif
            @endif
        </span>
        <span x-data="{ focused: false }">
            <input @focus="focused = true" @blur="focused = false" type="file" id="avatar" wire:model="avatar" class="sr-only">
            <label
                for="avatar"
                class="cursor-pointer inline-flex items-center text-center justify-center border rounded-md transition ease-in-out duration-150 focus:outline-none disabled:cursor-not-allowed disabled:opacity-75 bg-gray-1 border-gray-7 text-gray-11 hover:bg-gray-2 hover:border-gray-8 focus:ring-2 focus:ring-offset-2 focus:ring-gray-7 px-2.5 py-1.5 text-xs uppercase tracking-wide font-semibold shadow-sm"
                :class="{ 'border-blue-7 ring': focused }"
            >
                Change
            </label>
            <input type="hidden" name="avatar_path" wire:model="path">
        </span>
    </div>

    @error('avatar')
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-red-11 space-x-2" role="alert">
            @icon('alert', 'h-5 w-5 flex-shrink-0 text-red-9')
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
