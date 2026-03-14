<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class UploadAvatar extends UploadImage
{
    public ?string $mediaCollectionName = 'avatar';

    public ?string $modelAttribute = 'avatar_url';

    public ?string $croppedPath = null;

    protected string $filename = 'livewire.media.upload-avatar';

    #[On('croppedImageReady')]
    public function handleCroppedImage($path)
    {
        $this->croppedPath = $path;
    }

    #[On('mediaUploaded')]
    public function launchCropper()
    {
        $this->dispatch(
            'modal.open',
            AvatarEditor::class,
            ['temporaryUrl' => $this->image->temporaryUrl()]
        );
    }

    #[Computed]
    public function path(): ?string
    {
        if (is_null($this->image)) {
            return null;
        }

        return $this->croppedPath
            ? Storage::disk('public')->path($this->croppedPath)
            : $this->image?->getRealPath();
    }

    #[Computed]
    public function previewUrl(): ?string
    {
        if (! is_null($this->croppedPath) && Storage::disk('public')->exists($this->croppedPath)) {
            return Storage::url($this->croppedPath);
        }

        return $this->image?->temporaryUrl();
    }
}
