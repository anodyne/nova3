<?php

declare(strict_types=1);

namespace Nova\Media\Livewire;

class UploadAvatar extends UploadImage
{
    public ?string $mediaCollectionName = 'avatar';

    public ?string $modelAttribute = 'avatar_url';

    protected string $filename = 'livewire.media.upload-avatar';
}
