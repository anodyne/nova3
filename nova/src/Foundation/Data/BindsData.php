<?php namespace Nova\Foundation\Data;

trait BindsData
{
	protected $data = [];
	
	public function with(array $data)
	{
		$this->data = array_merge_recursive($this->data, $data);

		return $this;
	}
}
