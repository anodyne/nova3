<?php

namespace Nova\Foundation\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImage extends Component
{
    use WithFileUploads;

    public $existingImage;

    public $image;

    public $path;

    public function updatedImage()
    {
        $this->validate([
            'image' => ['image', 'max:5000'],
        ]);

        $this->path = $this->image->getRealPath();
    }

    public function render()
    {
        return view('livewire.upload-image');
    }
}
