<?php namespace Nova\Foundation\Data;

interface Deletable
{
	public function delete($resource);
	public function with(array $data);
}
