<?php

declare(strict_types=1);

namespace Nova\Media\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Models\Model;
use Nova\Media\Enums\ImageAction;

class UploadImage
{
    use AsAction;

    public function handle(Model $model, string $collection, ImageAction $action, ?string $tempPath = null): Model
    {
        return match ($action) {
            ImageAction::Unchanged => $model->refresh(),
            ImageAction::Remove => $this->handleImageRemoval(model: $model, collection: $collection),
            ImageAction::Add => $this->handleImageAddition(model: $model, collection: $collection, tempPath: $tempPath),
            ImageAction::Replace => $this->handleImageReplacement(model: $model, collection: $collection, tempPath: $tempPath),
        };
    }

    protected function handleImageRemoval(Model $model, string $collection): Model
    {
        $model->clearMediaCollection($collection);

        $activityName = $this->getActivityName($collection);

        activity()
            ->performedOn($model)
            ->event('removed '.$activityName)
            ->log('removed '.$activityName);

        return $model->refresh();
    }

    protected function handleImageAddition(Model $model, string $collection, ?string $tempPath): Model
    {
        // Guard: ensure we actually have a temp file
        if (blank($tempPath)) {
            // Treat as unchanged if nothing to add (non-destructive)
            return $model->refresh();
        }

        $model->addMedia($tempPath)->toMediaCollection($collection);

        $activityName = $this->getActivityName($collection);

        activity()
            ->performedOn($model)
            ->event('uploaded '.$activityName)
            ->log('uploaded '.$activityName);

        return $model->refresh();
    }

    protected function handleImageReplacement(Model $model, string $collection, ?string $tempPath): Model
    {
        // Guard: if no temp file, do nothing (non-destructive)
        if (blank($tempPath)) {
            return $model->refresh();
        }

        $model->clearMediaCollection($collection);
        $model->addMedia($tempPath)->toMediaCollection($collection);

        $activityName = $this->getActivityName($collection);

        activity()
            ->performedOn($model)
            ->event('replaced '.$activityName)
            ->log('replaced '.$activityName);

        return $model->refresh();
    }

    protected function getActivityName(string $collection): string
    {
        return str($collection)->replace('-', ' ')->toString();
    }
}
