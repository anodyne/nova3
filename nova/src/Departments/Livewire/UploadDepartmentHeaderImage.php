<?php

namespace Nova\Departments\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDepartmentHeaderImage extends Component
{
    use WithFileUploads;

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
        return view('livewire.departments.upload-header-image');
    }
}
