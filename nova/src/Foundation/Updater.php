<?php namespace Nova\Foundation;

abstract class Updater
{
	protected $data = [];
	protected $item;
	protected $repo;

	public function update($item)
	{
		$this->item = $item;

		// Handle anything that should happen before updating the item
		$this->beforeUpdate();

		// Update the item
		$this->item = $this->repo->update($this->item, $this->data);

		// Handle anything that should happen after updating the item
		$this->afterUpdate();

		// Fire any events we need to
		$this->fireEvents();

		return $this->item;
	}

	public function afterUpdate()
	{
		//
	}

	public function beforeUpdate()
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
