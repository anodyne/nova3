<?php

declare(strict_types=1);

namespace Nova\Media\Concerns;

use Spatie\MediaLibrary\InteractsWithMedia as BaseInteractsWithMedia;

trait InteractsWithMedia
{
    use BaseInteractsWithMedia;

    abstract public static function getMediaPath(): string;
}
