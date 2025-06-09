@php
    $media = $model?->getFirstMedia($mediaCollectionName);
    $existingMedia = $media ? json_encode(['url' => $media->getFullUrl()]) : 'null';
@endphp

<div data-slot="control">
    <div x-data="filepond({{ $existingMedia }})" x-init x-cloak wire:ignore class="w-full">
        <input type="file" accept="image/png,image/jpeg,image/gif" x-ref="input" />
    </div>

    <input type="hidden" name="image_path" value="{{ $path }}" />

    @error('image')
        <p class="mt-2 flex items-center space-x-2 text-sm text-danger-600" role="alert">
            <x-icon name="alert" size="sm" class="shrink-0 text-danger-500" />
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
