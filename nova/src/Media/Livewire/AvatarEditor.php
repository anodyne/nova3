<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;
use Nova\Foundation\Livewire\Modal;

class AvatarEditor extends Modal
{
    use WithFileUploads;

    public $croppedImage;

    public ?string $temporaryUrl = null;

    public function updatedCroppedImage()
    {
        if (! $this->croppedImage) {
            logger()->warning('No croppedImage file found on update.');

            return;
        }

        $path = $this->croppedImage->store('avatars', 'public');

        $this->dispatch('croppedImageReady', path: $path);

        $this->close();
    }

    public function render(): View
    {
        return view('livewire.media.avatar-editor');
    }
}
