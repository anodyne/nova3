@use('Illuminate\Support\Facades\Storage')
@use('Nova\Foundation\Nova')
@use('Nova\Settings\Enums\AvatarShape')

<div class="isolate flex items-center gap-4">
    @if (filled($image))
        <img
            src="{{ $previewUrl }}"
            alt="user photo"
            @class([
            'h-16 w-16 object-cover',
            'rounded-[20%]' => settings('appearance.avatarShape') === AvatarShape::Square,
            'rounded-full' => settings('appearance.avatarShape') === AvatarShape::Circle,
            ])
        />
    @else
        @if (filled($existingImage))
            <img
                src="{{ $existingImage }}"
                alt="user photo"
                @class([
                'h-16 w-16 object-cover',
                'rounded-[20%]' => settings('appearance.avatarShape') === AvatarShape::Square,
                'rounded-full' => settings('appearance.avatarShape') === AvatarShape::Circle,
                ])
            />
        @else
            <div
                @class([
                'flex h-16 w-16 items-center justify-center bg-gray-950/5 object-cover ring-1 ring-gray-950/5 ring-inset dark:bg-white/5 dark:ring-white/5',
                'rounded-[20%]' => settings('appearance.avatarShape') === AvatarShape::Square,
                'rounded-full' => settings('appearance.avatarShape') === AvatarShape::Circle,
                ])
            >
                <div class="text-gray-500 dark:text-gray-400">
                    <x-icon :name="Tabler::User" size="2xl" />
                </div>
            </div>
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
                    class="peer-focus:ring-primary-600 pointer-events-none block rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-slate-300 ring-inset peer-hover:bg-slate-50 peer-focus:ring-2 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:peer-hover:bg-white/10"
                >
                    <div class="flex items-center gap-x-2">
                        <div>
                            <span>Change</span>
                            <span class="sr-only">user photo</span>
                        </div>
                        <div wire:loading wire:target="image">
                            <flux:icon.loading class="size-4" />
                        </div>
                    </div>
                </label>
            </div>

            @if ($hasImage)
                <x-button type="button" variant="subtle" square wire:click="removeImage">
                    <x-icon :name="Tabler::Trash" size="sm" />
                </x-button>
            @endif
        </div>

        <p class="text-sm font-medium text-gray-500">{{ $supportMessage }}</p>

        @error('image')
            <p class="text-danger-600 relative mt-2 ml-0.5 flex w-full items-center space-x-2 text-sm" role="alert">
                <x-icon :name="Tabler::AlertCircle" size="sm" class="text-danger-500 shrink-0" />
                <span>{{ $message }}</span>
            </p>
        @enderror
    </div>

    <input type="hidden" name="{{ $fieldTempFile }}" value="{{ $imageTempPath }}" />
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
