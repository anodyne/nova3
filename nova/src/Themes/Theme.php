<?php

namespace Nova\Themes;

use Nova\Pages\Page;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
	protected $fillable = [
		'name', 'path', 'layout_admin', 'layout_auth', 'layout_data_auth', 'layout_landing',
		'layout_site', 'layout_settings',
	];

	protected $casts = [
		'layout_data_auth' => 'array'
	];

	/**
	 * Scope the query to the theme path.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @param  string
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePath($query, $value)
	{
		return $query->where('path', $value);
	}

	/**
	 * Get the layout file path for the given page.
	 *
	 * @param  \Nova\Pages\Page  $page
	 * @return string
	 */
	public function getLayoutForPage(Page $page)
	{
		return $this->getAttribute("layout_{$page->layout}");
	}

	public function getLayoutDataForPage(Page $page)
	{
		return $this->getAttribute("layout_data_{$page->layout}");
	}
}
