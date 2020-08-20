<div class="flex flex-col">
    <div class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
        <div class="text-center">
            @icon('image-add', 'mx-auto h-12 w-12 text-gray-400')
            <p class="mt-1 text-sm text-gray-600">
                <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition duration-150 ease-in-out">
                    Upload a file
                </button>
            </p>
            <p class="mt-1 text-xs text-gray-500">
                PNG, JPG, GIF up to 5MB
            </p>
        </div>
    </div>

    <div class="mt-2">
        <input type="file" wire:model="image">
        <input type="hidden" name="image_path" wire:model="path">
    </div>

    @error('image')
        <div class="field-error" role="alert">
            @icon('alert')
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>
