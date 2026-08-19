<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Nova\Media\Enums\ImageAction;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read bool $hasImage
 * @property-read TemporaryUploadedFile|null $imageInfo
 * @property-read ?string $previewUrl
 * @property-read string $fieldImageAction
 * @property-read string $fieldTempFile
 */
class UploadImage extends Component
{
    use WithFileUploads;

    public string $actionMessage = 'Upload a file';

    public ?string $existingImage = null;

    public string $fieldName = 'image';

    #[Validate('image:allow_svg|max:10240')]
    public $image = null;

    public ImageAction $imageAction = ImageAction::Unchanged;

    public ?string $imageTempPath = null;

    #[Locked]
    public bool $initialHasExisting = false;

    public ?string $mediaCollectionName = null;

    #[Locked]
    public ?Model $model = null;

    public ?string $modelAttribute = null;

    public string $supportMessage = 'PNG, JPG, or GIF (max. 10MB)';

    protected string $filename = 'livewire.media.upload-image';

    #[Computed]
    public function fieldImageAction(): string
    {
        return $this->fieldName.'_action';
    }

    #[Computed]
    public function fieldTempFile(): string
    {
        return $this->fieldName.'_temp_path';
    }

    #[Computed]
    public function hasImage(): bool
    {
        return filled($this->image) || filled($this->existingImage);
    }

    #[Computed]
    public function imageInfo()
    {
        if (filled($this->image)) {
            return $this->image;
        }

        // return $this->existingImage;
    }

    public function mount(): void
    {
        $media = $this->model instanceof HasMedia
            ? $this->model->getMedia($this->mediaCollectionName ?? 'default')->first()
            : null;

        $this->existingImage = $media instanceof Media ? $media->getUrl() : null;

        $this->initialHasExisting = filled($this->existingImage);
        $this->imageAction = ImageAction::Unchanged;
        $this->imageTempPath = null;
    }

    #[Computed]
    public function previewUrl(): ?string
    {
        if (filled($this->image)) {
            return $this->image->temporaryUrl();
        }

        return $this->existingImage;
    }

    public function removeImage(): void
    {
        if (filled($this->image)) {
            // User had selected a new file; cancel that selection.
            $this->image = null;
            $this->imageTempPath = null;
            $this->imageAction = ImageAction::Unchanged;
        } elseif ($this->initialHasExisting) {
            // No new file, but existing media at mount → schedule removal.
            $this->existingImage = null; // purely for preview purposes
            $this->imageAction = ImageAction::Remove;
            $this->imageTempPath = null;
        } else {
            // Nothing to remove.
            $this->imageAction = ImageAction::Unchanged;
            $this->imageTempPath = null;
        }
    }

    public function render()
    {
        return view($this->filename, [
            'hasImage' => $this->hasImage,
            'imageInfo' => $this->imageInfo,
            'previewUrl' => $this->previewUrl,
            'fieldImageAction' => $this->fieldImageAction,
            'fieldTempFile' => $this->fieldTempFile,
        ]);
    }

    public function updatedImage($value): void
    {
        if (filled($this->image)) {
            // If there was existing media at mount time, we're replacing; otherwise, adding.
            $this->imageAction = $this->initialHasExisting ? ImageAction::Replace : ImageAction::Add;
            $this->imageTempPath = $this->image->getRealPath() ?: null;

            $this->dispatch('mediaUploaded', action: $this->imageAction->value, path: $this->imageTempPath);
        } else {
            // If image was cleared by the browser/UX, reset to unchanged.
            $this->imageAction = ImageAction::Unchanged;
            $this->imageTempPath = null;
        }
    }
}
