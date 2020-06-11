<?php

namespace Nova\Users\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UserUploadAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public $path;

    public function updatedAvatar()
    {
        $this->path = $this->avatar->getRealPath();
    }

    public function render()
    {
        return view('livewire.users.upload-avatar');
    }
}
