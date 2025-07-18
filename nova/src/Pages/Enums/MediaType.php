<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum MediaType: string implements HasLabel
{
    case None = 'none';

    case Image = 'image';

    case Video = 'video';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::None => 'No media',
            self::Image => 'Image',
            self::Video => 'Video',
        };
    }
}
