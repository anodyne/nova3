<?php

declare(strict_types=1);

namespace Nova\Foundation\Support\IdeHelper;

use Bag\Bag;
use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;

class BagCastModelHook implements ModelHookInterface
{
    public function run(ModelsCommand $command, Model $model): void
    {
        $columns = collect(
            $model->getConnection()
                ->getSchemaBuilder()
                ->getColumns($model->getTable())
        )->keyBy('name');

        foreach ($model->getCasts() as $attribute => $cast) {
            if (! is_string($cast)) {
                continue;
            }

            $castClass = explode(':', $cast, 2)[0];

            if (! class_exists($castClass) || ! is_a($castClass, Bag::class, true)) {
                continue;
            }

            $column = $columns->get($attribute);

            $command->setProperty(
                name: $attribute,
                type: '\\'.ltrim($castClass, '\\'),
                nullable: $column['nullable'] ?? false
            );
        }
    }
}
