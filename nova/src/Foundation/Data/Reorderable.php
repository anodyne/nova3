<?php namespace Nova\Foundation\Data;

trait Reorderable
{
	public function reorder($newOrder)
	{
		return updater(self::class)->with(['order' => $newOrder])->update($this);
	}
}
