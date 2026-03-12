@use('Nova\Media\Enums\ImageAction')

@php
    $media = $model?->getFirstMedia($mediaCollectionName);
    $existingMedia = $media ? json_encode(['url' => $media->getFullUrl()]) : 'null';
@endphp

<div>
    <flux:file-upload wire:model="image">
        <flux:file-upload.dropzone :heading="$actionMessage" :text="$supportMessage" inline with-progress />
    </flux:file-upload>

    @if ($image || $existingImage)
        <div class="mt-3 flex flex-col gap-2">
            <flux:file-item
                :heading="$imageInfo?->getClientOriginalName()"
                :image="$imageInfo?->temporaryUrl()"
                :size="$imageInfo?->getSize()"
            >
                <x-slot name="actions">
                    <flux:file-item.remove
                        wire:click="removeImage"
                        aria-label="{{ 'Remove file: '.$imageInfo?->getClientOriginalName() }}"
                    />
                </x-slot>
            </flux:file-item>
        </div>
    @endif

    <input type="hidden" name="{{ $fieldImageAction }}" value="{{ $imageAction->value }}" />

    @if (in_array($imageAction, [ImageAction::Add, ImageAction::Replace], true) && filled($imageTempPath))
        <input type="hidden" name="{{ $fieldTempFile }}" value="{{ $imageTempPath }}" />
    @endif
</div>
{{--
    <div>
    <div x-data="filepond({{ $existingMedia }})" x-init x-cloak wire:ignore class="w-full">
    <input type="file" accept="image/png,image/jpeg,image/gif" x-ref="input" />
    </div>
    
    <input type="hidden" name="{{ $fieldImageAction }}" value="{{ $imageAction->value }}" />
    
    @if (in_array($imageAction, [ImageAction::Add, ImageAction::Replace], true) && filled($imageTempPath))
    <input type="hidden" name="{{ $fieldTempFile }}" value="{{ $imageTempPath }}" />
    @endif
    
    @error('image')
    <p class="text-danger-600 mt-2 flex items-center space-x-2 text-sm" role="alert">
    <x-icon :name="Tabler::AlertCircle" size="sm" class="text-danger-500 shrink-0" />
    <span>{{ $message }}</span>
    </p>
    @enderror
    </div>
--}}
