@use('Nova\Foundation\Nova')

<div data-slot="control" class="isolate flex items-center gap-x-4">
    @if (filled($image))
        <img
            src="{{ $image->temporaryUrl() }}"
            alt="user photo"
            @class([
                'h-16 w-16 object-cover',
                'rounded-[20%]' => settings('appearance.avatarShape') === 'square',
                'rounded-full' => settings('appearance.avatarShape') === 'circle',
            ])
        />
    @else
        @if (filled($existingImage))
            <img
                src="{{ $existingImage }}"
                alt="user photo"
                @class([
                    'h-16 w-16 object-cover',
                    'rounded-[20%]' => settings('appearance.avatarShape') === 'square',
                    'rounded-full' => settings('appearance.avatarShape') === 'circle',
                ])
            />
        @else
            <img
                src="{{ Nova::getAvatarUrl('nova3') }}"
                alt="generated user photo"
                @class([
                    'h-16 w-16 object-cover',
                    'rounded-[20%]' => settings('appearance.avatarShape') === 'square',
                    'rounded-full' => settings('appearance.avatarShape') === 'circle',
                ])
            />
        @endif
    @endif

    <div class="flex flex-col gap-y-1">
        <div class="flex items-center gap-x-4">
            <div class="relative flex items-center">
                <input
                    id="user-photo"
                    name="user-photo"
                    type="file"
                    class="peer absolute inset-0 h-full w-full rounded-md opacity-0"
                    wire:model="image"
                />

                <label
                    for="user-photo"
                    class="pointer-events-none block rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 peer-hover:bg-slate-50 peer-focus:ring-2 peer-focus:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:peer-hover:bg-white/10"
                >
                    <span>Change</span>
                    <span class="sr-only">user photo</span>
                </label>

                @if (blank($existingImage))
                    <div
                        class="relative z-10 ml-4 text-gray-500"
                        x-tooltip.delay.250.raw="This is a unique generated avatar for your account"
                    >
                        <x-icon name="info" size="sm"></x-icon>
                    </div>
                @endif
            </div>

            @if ($hasImage)
                <x-button color="neutral-danger" wire:click="removeImage" text>
                    <x-icon name="trash" size="sm"></x-icon>
                </x-button>
            @endif
        </div>

        <p class="text-sm font-medium text-gray-500">{{ $supportMessage }}</p>

        @error('image')
            <p class="relative ml-0.5 mt-2 flex w-full items-center space-x-2 text-sm text-danger-600" role="alert">
                <x-icon name="alert" size="sm" class="shrink-0 text-danger-500"></x-icon>
                <span>{{ $message }}</span>
            </p>
        @enderror
    </div>

    <input type="hidden" name="image_path" value="{{ $path }}" />
    <label for="remove_existing_image" class="sr-only">
        <div>Remove existing user photo</div>
        <input
            type="checkbox"
            name="remove_existing_image"
            id="remove_existing_image"
            wire:model="removeExistingImage"
        />
    </label>
</div>
