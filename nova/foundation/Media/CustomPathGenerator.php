<?php

namespace Nova\Foundation\Media;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        if ($media->model::MEDIA_DIRECTORY) {
            return strtr($media->model::MEDIA_DIRECTORY, [
                '{media_id}' => $media->id,
                '{model_id}' => $media->model_id,
            ]);
        }

        return "{$media->id}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}
