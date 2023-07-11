<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImage extends Component
{
    use WithFileUploads;

    public $existingImage;

    public $image;

    public $path;

    public $actionMessage = 'Upload a file';

    public $supportMessage = 'PNG, JPG, GIF up to 5MB';

    public function updatedImage()
    {
        $this->validate([
            'image' => ['image', 'max:5000'],
        ]);

        $this->path = $this->image->getRealPath();
    }

    public function render()
    {
        return view('livewire.media.upload-image');
    }
}
