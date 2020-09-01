<?php

namespace Nova\Foundation\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public $existingAvatar;

    public $newAvatar;

    public $path;

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => ['image', 'max:5000'],
        ]);

        $this->path = $this->avatar->getRealPath();
    }

    public function mount($existingAvatar = null)
    {
        $this->existingAvatar = $existingAvatar;
    }

    public function render()
    {
        return view('livewire.upload-avatar');
    }
}
