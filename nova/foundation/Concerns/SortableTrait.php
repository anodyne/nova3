<?php

namespace Nova\Foundation\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait as BaseSortableTrait;

trait SortableTrait
{
    use BaseSortableTrait;

    public function moveBefore(Sortable $otherModel): static
    {
        if (!$otherModel instanceof Model) {
            throw new InvalidArgumentException();
        }

        if ($otherModel->getTable() !== $this->getTable()) {
            throw new InvalidArgumentException();
        }

        if ($otherModel->getKey() === $this->getKey()) {
            return $this;
        }

        $orderColumnName = $this->determineOrderColumnName();

        $this->$orderColumnName = $otherModel->$orderColumnName;
        $this->save();

        $this->buildSortQuery()
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->where($orderColumnName, '>=', $this->$orderColumnName)
            ->increment($orderColumnName);

        return $this;
    }

    public function moveAfter(Sortable $otherModel): static
    {
        if (!$otherModel instanceof Model) {
            throw new InvalidArgumentException();
        }

        if ($otherModel->getTable() !== $this->getTable()) {
            throw new InvalidArgumentException();
        }

        if ($otherModel->getKey() === $this->getKey()) {
            return $this;
        }

        $orderColumnName = $this->determineOrderColumnName();

        $this->$orderColumnName = $otherModel->$orderColumnName + 1;
        $this->save();

        $this->buildSortQuery()
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->where($orderColumnName, '>=', $this->$orderColumnName)
            ->increment($orderColumnName);

        return $this;
    }
}
