<div class="flex flex-col">
    <div class="flex items-center space-x-6">
        <div class="shrink-0">
            @if ($avatar)
                <img src="{{ $avatar->temporaryUrl() }}" alt="avatar" class="h-16 w-16 object-cover rounded-full">
            @else
                @if ($existingAvatar)
                    <img src="{{ $existingAvatar }}" alt="avatar" class="h-16 w-16 object-cover rounded-full">
                @else
                    <div class="rounded-full bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-200/[15%]">
                        <div class="p-3">
                            @icon('user', 'h-10 w-10 text-gray-400 dark:text-gray-500')
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <label for="avatar" class="block">
            <span class="sr-only">Choose profile photo</span>
            <input type="file" id="avatar" wire:model="avatar" class="block w-full text-sm file:cursor-pointer file:uppercase file:tracking-wide file:shadow-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-1.5 file:px-2.5 file:rounded-md file:text-xs file:font-semibold file:bg-white dark:file:bg-gray-800 file:text-gray-500 file:border file:border-solid file:border-gray-300 dark:file:border-gray-200/10 hover:file:bg-gray-50 dark:hover:file:bg-gray-900/40 hover:file:border-gray-400/75 dark:hover:file:border-gray-200/20 file:transition focus:outline-none">
        </label>

        <input type="hidden" name="avatar_path" wire:model="path">
    </div>

    @error('avatar')
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-error-600 space-x-2" role="alert">
            @icon('alert', 'h-5 w-5 shrink-0 text-error-500')
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
