<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use LogicException;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Support\FactoryRequestData;

trait CanHandleDataForRequests
{
    public function forRequest(array $attributes = []): FactoryRequestData
    {
        $model = $this->make($attributes);

        if (! $model instanceof Model) {
            throw new LogicException('Request data can only be generated for one model at a time.');
        }

        $payload = Arr::except($model->getAttributes(), ['status']);

        if ($model->getAttribute('status') === BasicStatus::Active) {
            $payload['status'] = 'true';
        }

        return FactoryRequestData::from(model: $model, payload: $payload);
    }
}
