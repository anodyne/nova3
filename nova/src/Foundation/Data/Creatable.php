<?php namespace Nova\Foundation\Data;

interface Creatable
{
	public function create();
	public function with(array $data);
}
