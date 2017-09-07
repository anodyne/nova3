<?php namespace Nova\Foundation\Data;

interface Deactivatable
{
	public function deactivate($resource);
	public function with(array $data);
}
