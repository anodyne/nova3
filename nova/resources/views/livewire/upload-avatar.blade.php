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
                            <x-icon name="user" size="h-10 w-10" class="text-gray-400 dark:text-gray-500"></x-icon>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <label for="avatar" class="block">
            <span class="sr-only">Choose profile photo</span>
            <input type="file" id="avatar" wire:model="avatar" @class([
                'block w-full text-sm text-gray-600 dark:text-gray-400',
                'file:mr-4 file:py-1.5 file:px-2.5 file:cursor-pointer',
                'file:rounded-md file:shadow-sm file:text-sm file:font-medium file:border file:border-solid file:transition focus:outline-none file:bg-transparent',
                'file:text-primary-500 hover:file:text-primary-600  file:border-primary-300 hover:file:border-primary-400',
                'dark:file:hover:text-primary-400 dark:file:border-primary-700 dark:file:hover:border-primary-600',
            ])>
        </label>

        <input type="hidden" name="avatar_path" wire:model="path">
    </div>

    @error('avatar')
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-danger-600 space-x-2" role="alert">
            <x-icon name="alert" size="sm" class="shrink-0 text-danger-500"></x-icon>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
