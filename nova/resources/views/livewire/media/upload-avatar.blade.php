<div class="flex flex-col">
    <div class="flex items-center space-x-6">
        <div class="shrink-0">
            @if ($avatar)
                <img
                    src="{{ $avatar->temporaryUrl() }}"
                    alt="avatar"
                    @class([
                        'h-16 w-16 object-cover',
                        match (settings('appearance.avatarShape')) {
                            'squircle' => 'mask mask-squircle',
                            'hexagon' => 'mask mask-hexagon',
                            'hexagon-alt' => 'mask mask-hexagon-alt',
                            default => settings('appearance.avatarShape'),
                        },
                    ])
                />
            @else
                @if ($existingAvatar)
                    <img
                        src="{{ $existingAvatar }}"
                        alt="avatar"
                        @class([
                            'h-16 w-16 object-cover',
                            match (settings('appearance.avatarShape')) {
                                'squircle' => 'mask mask-squircle',
                                'hexagon' => 'mask mask-hexagon',
                                'hexagon-alt' => 'mask mask-hexagon-alt',
                                default => settings('appearance.avatarShape'),
                            },
                        ])
                    />
                @else
                    <div
                        @class([
                            'border border-gray-200 bg-gray-50 dark:border-gray-200/[15%] dark:bg-gray-700/50',
                            match (settings('appearance.avatarShape')) {
                                'squircle' => 'mask mask-squircle',
                                'hexagon' => 'mask mask-hexagon',
                                'hexagon-alt' => 'mask mask-hexagon-alt',
                                default => settings('appearance.avatarShape'),
                            },
                        ])
                    >
                        <div class="p-3">
                            <x-icon name="user" size="h-10 w-10" class="text-gray-400 dark:text-gray-500"></x-icon>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div class="flex flex-col space-y-2">
            <label for="avatar" class="block">
                <span class="sr-only">Choose profile photo</span>
                <input
                    type="file"
                    id="avatar"
                    wire:model="avatar"
                    @class([
                        'block w-full text-sm text-gray-600 dark:text-gray-400',
                        'file:mr-4 file:inline-flex file:cursor-pointer file:border-none file:px-2.5 file:py-1',
                        'file:rounded-md file:bg-white file:text-sm file:text-sm file:font-semibold file:shadow-sm file:ring-1 file:ring-inset file:transition focus:outline-none dark:file:bg-gray-900',
                        'file:text-primary-500 file:ring-primary-400 hover:file:bg-primary-50',
                        'dark:file:text-primary-400 dark:file:ring-primary-700 dark:hover:file:bg-primary-950/50',
                    ])
                />
            </label>

            @if ($hasAvatar)
                <div>
                    <x-button.text
                        type="button"
                        color="neutral-danger"
                        leading="trash"
                        size="none-xs"
                        wire:click="removeAvatar"
                    >
                        Remove profile picture
                    </x-button.text>
                </div>
            @endif
        </div>

        <input type="hidden" name="avatar_path" wire:model="path" />
        <input type="hidden" name="remove_avatar" wire:model="shouldRemoveAvatar" />
    </div>

    @error('avatar')
        <p class="relative ml-0.5 mt-2 flex w-full items-center space-x-2 text-sm text-danger-600" role="alert">
            <x-icon name="alert" size="sm" class="shrink-0 text-danger-500"></x-icon>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
