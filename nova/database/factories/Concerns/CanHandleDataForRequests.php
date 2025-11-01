<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use Illuminate\Support\Arr;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Support\FactoryRequestData;

trait CanHandleDataForRequests
{
    public function forRequest(array $attributes = []): FactoryRequestData
    {
        $model = $this->make($attributes);

        $payload = Arr::except($model->getAttributes(), ['status']);

        if ($model->status === BasicStatus::Active) {
            $payload['status'] = 'true';
        }

        return FactoryRequestData::from(model: $model, payload: $payload);
    }
}
