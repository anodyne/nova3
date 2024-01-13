<div data-slot="control" class="isolate flex flex-col">
    <div
        class="flex w-full justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pb-6 pt-5 dark:border-gray-500"
    >
        <div class="shrink-0 text-center">
            <div class="flex flex-col items-center">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="image" class="h-16 w-16" />
                @else
                    @if ($existingImage)
                        <img src="{{ $existingImage }}" alt="image" class="h-16 w-16" />
                    @else
                        <x-icon name="image" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>
                    @endif
                @endif
            </div>

            <div class="mt-4 text-center">
                <p x-data="{ focused: false }" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <input
                        @focus="focused = true"
                        @blur="focused = false"
                        type="file"
                        id="upload-image"
                        wire:model="image"
                        class="sr-only"
                    />
                    <label
                        for="upload-image"
                        class="cursor-pointer font-medium text-primary-500 transition hover:text-primary-600 dark:hover:text-primary-400"
                        :class="{ 'outline-none underline': focused }"
                    >
                        {{ $actionMessage }}
                    </label>
                </p>
                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    {{ $supportMessage }}
                </p>
            </div>
        </div>
    </div>

    <input type="hidden" name="image_path" value="{{ $path }}" />

    @error('image')
        <p class="relative ml-0.5 mt-2 flex w-full items-center space-x-2 text-sm text-danger-600" role="alert">
            <x-icon name="alert" size="sm" class="shrink-0 text-danger-500"></x-icon>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
