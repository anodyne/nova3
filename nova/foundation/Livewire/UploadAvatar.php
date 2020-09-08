<?php

namespace Nova\Foundation\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public $existingAvatar;

    public $path;

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => ['image', 'max:5000'],
        ]);

        $this->path = $this->avatar->getRealPath();
    }

    public function render()
    {
        return view('livewire.upload-avatar');
    }
}
