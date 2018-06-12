<?php

namespace Nova\Foundation\Presenters;

use Robbo\Presenter\PresentableInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection as BaseCollection;

class Collection extends BaseCollection
{
	public function toArray()
	{
		return array_map(function ($value) {
			if ($value instanceof PresentableInterface) {
				return $value->getPresenter()->toArray();
			}

			if ($value instanceof Arrayable) {
				return $value->toArray();
			}

			return $value;
		}, $this->items);
	}

	public function jsonSerialize()
	{
		return array_map(function ($value) {
			if ($value instanceof PresentableInterface) {
				return $value->getPresenter()->toArray();
			} elseif ($value instanceof JsonSerializable) {
				return $value->jsonSerialize();
			} elseif ($value instanceof Jsonable) {
				return json_decode($value->toJson(), true);
			} elseif ($value instanceof Arrayable) {
				return $value->toArray();
			}

			return $value;
		}, $this->items);
	}
}
