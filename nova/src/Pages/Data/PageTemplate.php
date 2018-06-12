<?php

namespace Nova\Pages\Data;

use Model;

class PageTemplate extends Model
{
	public function pages()
	{
		return $this->belongsTo(Page::class);
	}
}
