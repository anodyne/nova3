<?php

namespace Nova\Themes;

use Nova\Pages\Page;
use Nova\Themes\Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Theme extends Model
{
    protected $fillable = [
        'name', 'location', 'credits', 'layout_auth', 'layout_public',
        'layout_admin',
    ];

    protected $dispatchesEvents = [
        'created' => Events\ThemeCreated::class,
        'updated' => Events\ThemeUpdated::class,
        'deleted' => Events\ThemeDeleted::class,
    ];

    /**
     * Scope the query to the location column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $location
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLocation(Builder $query, $location)
    {
        $query->where('location', $location);
    }

    /**
     * Get the layout to use for the page.
     *
     * @param  \Nova\Pages\Page  $page
     * @return string
     */
    public function getLayoutForPage(Page $page)
    {
        return $this->getAttribute("layout_{$page->layout}");
    }
}