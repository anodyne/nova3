<div class="flex flex-col">
    <div class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-500 border-dashed rounded-md">
        <div class="shrink-0 text-center">
            <div class="flex flex-col items-center">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="image" class="h-16 w-16">
                @else
                    @if ($existingImage)
                        <img src="{{ $existingImage }}" alt="image" class="h-16 w-16">
                    @else
                        @icon('image', 'mx-auto h-12 w-12 text-gray-500')
                    @endif
                @endif
            </div>

            <div class="text-center mt-4">
                <p x-data="{ focused: false }" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <input
                        @focus="focused = true"
                        @blur="focused = false"
                        type="file"
                        id="upload-image"
                        wire:model="image"
                        class="sr-only"
                    >
                    <label
                        for="upload-image"
                        class="cursor-pointer font-medium text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition"
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

    <input type="hidden" name="image_path" wire:model="path">

    @error('image')
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-danger-600 space-x-2" role="alert">
            @icon('alert', 'h-5 w-5 shrink-0 text-danger-500')
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
