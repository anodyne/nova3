<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use Illuminate\Database\Eloquent\Model;

trait CanAddMedia
{
    protected function addRandomMedia(Model $model, string $source, string $destination, string $mediaCollection)
    {
        $sourceDirectory = base_path($source);
        $destinationDirectory = base_path($destination);

        if (! file_exists($sourceDirectory) || ! is_dir($sourceDirectory)) {
            return;
        }

        $files = glob($sourceDirectory.'/*.{jpg,jpeg,png,webp}', GLOB_BRACE);

        if (empty($files)) {
            return;
        }

        $randomFile = $files[array_rand($files)];
        $fileName = basename($randomFile);

        if (! file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0777, true);
        }

        $newFilePath = $destinationDirectory.'/'.uniqid().'_'.$fileName;
        copy($randomFile, $newFilePath);

        $model->clearMediaCollection($mediaCollection);

        $model
            ->addMedia($newFilePath)
            ->preservingOriginal()
            ->toMediaCollection($mediaCollection);

        if (file_exists($newFilePath)) {
            unlink($newFilePath);
        }
    }
}
