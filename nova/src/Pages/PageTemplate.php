<?php

namespace Nova\Pages;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
	public function pages()
	{
		return $this->belongsTo(Page::class);
	}
}
