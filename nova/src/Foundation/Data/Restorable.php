<?php namespace Nova\Foundation\Data;

interface Restorable
{
	public function restore($resource);
	public function with(array $data);
}
