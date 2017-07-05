<?php namespace Nova\Foundation;

abstract class Creator
{
	protected $data = [];
	protected $item;
	protected $repo;

	public function create()
	{
		// Handle anything that should happen before creating the item
		$this->beforeCreate();

		// Create the item
		$this->item = $this->repo->create($this->data);

		// Handle anything that should happen after creating the item
		$this->afterCreate();

		// Fire any events we need to
		$this->fireEvents();

		return $this->item;
	}

	public function afterCreate()
	{
		//
	}

	public function beforeCreate()
	{
		//
	}

	public function data(array $data)
	{
		$this->data = array_merge_recursive($this->data, $data);

		return $this;
	}

	public function fireEvents()
	{
		return $this;
	}
}
