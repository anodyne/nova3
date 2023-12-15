<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImage extends Component
{
    use WithFileUploads;

    public ?Model $model = null;

    public ?string $modelAttribute = null;

    public ?string $mediaCollectionName = null;

    public ?string $existingImage = null;

    public bool $removeExistingImage = false;

    #[Validate('image')]
    #[Validate('max:10000')]
    public $image = null;

    public string $actionMessage = 'Upload a file';

    public string $supportMessage = 'PNG, JPG, or GIF (max. 10MB)';

    protected string $filename = 'livewire.media.upload-image';

    #[Computed]
    public function hasImage(): bool
    {
        return filled($this->image) || filled($this->existingImage);
    }

    #[Computed]
    public function path(): ?string
    {
        return $this->image?->getRealPath();
    }

    public function removeImage(): void
    {
        if (filled($this->image)) {
            $this->image = null;
        } else {
            $this->existingImage = null;
            $this->removeExistingImage = true;
        }
    }

    public function mount()
    {
        $this->existingImage = $this->model?->hasMedia($this->mediaCollectionName)
            ? $this->model?->getFirstMediaUrl($this->mediaCollectionName)
            : null;
    }

    public function render()
    {
        return view($this->filename, [
            'hasImage' => $this->hasImage,
            'path' => $this->path,
        ]);
    }
}
