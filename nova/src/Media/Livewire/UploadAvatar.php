<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Nova\Media\Rules\MaxFileSize;

class UploadAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public $existingAvatar;

    public bool $hasAvatar = false;

    public $path;

    public bool $shouldRemoveAvatar = false;

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => ['image', new MaxFileSize()],
        ]);

        $this->path = $this->avatar->getRealPath();
    }

    public function removeAvatar(): void
    {
        $this->shouldRemoveAvatar = true;
        $this->existingAvatar = null;
    }

    public function render()
    {
        return view('livewire.media.upload-avatar');
    }
}
