<div class="flex flex-col">
    <div class="flex items-center space-x-6">
        <div class="shrink-0">
            @if ($avatar)
                <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar" class="h-16 w-16 object-cover rounded-full">
            @else
                @if ($existingAvatar)
                    <img src="{{ $existingAvatar }}" alt="Avatar" class="h-16 w-16 object-cover rounded-full">
                @else
                    <svg class="h-16 w-16 rounded-full text-gray-9 bg-gray-3 border border-gray-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                @endif
            @endif
        </div>

        <label for="avatar" class="block">
            <span class="sr-only">Choose profile photo</span>
            <input type="file" id="avatar" wire:model="avatar" class="block w-full text-sm file:cursor-pointer file:uppercase file:tracking-wide file:shadow-sm text-gray-11 file:mr-4 file:py-1.5 file:px-2.5 file:rounded-md file:text-xs file:font-semibold file:bg-gray-1 file:text-gray-11 file:border file:border-solid file:border-gray-7 hover:file:bg-gray-2 hover:file:border-gray-8 file:transition file:duration-200 focus:outline-none">
        </label>

        <input type="hidden" name="avatar_path" wire:model="path">
    </div>

    @error('avatar')
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-red-11 space-x-2" role="alert">
            @icon('alert', 'h-5 w-5 shrink-0 text-red-9')
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
