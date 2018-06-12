<?php

namespace Nova\Foundation\Presenters;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Robbo\Presenter\Presenter as BasePresenter;
use Illuminate\Database\Eloquent\JsonEncodingException;

abstract class Presenter extends BasePresenter implements Arrayable, Jsonable
{
	public function presentCreatedAt()
	{
		return $this->created_at->format('Y-m-d g:i:s a');
	}

	public function presentCreatedAtForHumans()
	{
		return $this->created_at->diffForHumans();
	}

	public function presentUpdatedAt()
	{
		return $this->updated_at->format('Y-m-d g:i:s a');
	}

	public function presentUpdatedAtForHumans()
	{
		return $this->updated_at->diffForHumans();
	}

	public function toArray()
	{
		$data = $this->object->toArray();

		if (method_exists($this, 'toPresentedArray')) {
			$data = array_merge($data, $this->toPresentedArray());
		}

		return $data;
	}

	public function toJson($options = 0)
	{
		$json = json_encode($this->toArray(), $options);

		if (JSON_ERROR_NONE !== json_last_error()) {
			throw JsonEncodingException::forModel($this, json_last_error_msg());
		}

		return $json;
	}

	// public function __toString()
	// {
	// 	return $this->toJson();
	// }
}
