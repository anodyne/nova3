<?php

declare(strict_types=1);

namespace Nova\Media\Providers;

use Nova\DomainServiceProvider;
use Nova\Media\Livewire\UploadAvatar;
use Nova\Media\Livewire\UploadImage;

class MediaServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'media-upload-avatar' => UploadAvatar::class,
            'media-upload-image' => UploadImage::class,
        ];
    }
}
