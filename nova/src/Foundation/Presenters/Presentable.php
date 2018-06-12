<?php

namespace Nova\Foundation\Presenters;

use Illuminate\Support\Str;
use Robbo\Presenter\PresentableInterface;
use Illuminate\Contracts\Support\Arrayable;

trait Presentable
{
	public function getPresenter()
	{
		return new $this->presenter($this);
	}

	public function relationsToArray()
	{
		$attributes = [];

		foreach ($this->getArrayableRelations() as $key => $value) {
			if ($value instanceof PresentableInterface) {
				$relation = $value->getPresenter()->toArray();
			} elseif ($value instanceof Arrayable) {
				$relation = $value->toArray();
			} elseif (is_null($value)) {
				$relation = $value;
			}

			if (static::$snakeAttributes) {
				$key = Str::snake($key);
			}

			if (isset($relation) or is_null($value)) {
				$attributes[$key] = $relation;
			}

			unset($relation);
		}

		return $attributes;
	}

	public function newCollection(array $models = [])
	{
		return new Collection($models);
	}
}
