<?php

declare(strict_types=1);

namespace Nova\Media;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $model = $media::getActualClassNameForMorph($media->model_type);

        if (method_exists($model, 'getMediaPath')) {
            return strtr($model::getMediaPath(), [
                '{media_id}' => $media->id,
                '{model_id}' => $media->model_id,
            ]);
        }

        return "{$media->id}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'responsive-images/';
    }
}
