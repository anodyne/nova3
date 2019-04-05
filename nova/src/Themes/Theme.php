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
        'layout_admin', 'layout_auth_settings', 'layout_public_settings',
        'layout_admin_settings', 'icon_set',
    ];

    protected $casts = [
        'layout_auth_settings' => 'json',
        'layout_public_settings' => 'json',
        'layout_admin_settings' => 'json',
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

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Nova\Themes\ThemesCollection
     */
    public function newCollection(array $models = [])
    {
        return new ThemesCollection($models);
    }
}