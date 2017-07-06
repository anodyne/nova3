<?php namespace Nova\Foundation\Data;

interface Updatable
{
	public function update($resource);
	public function with(array $data);
}
