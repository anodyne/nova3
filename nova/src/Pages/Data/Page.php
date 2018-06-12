<?php

namespace Nova\Pages\Data;

use Model;

class Page extends Model
{
	protected $with = ['template'];

	public function template()
	{
		return $this->hasOne(PageTemplate::class);
	}
}
