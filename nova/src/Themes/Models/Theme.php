<?php

namespace Nova\Themes\Models;

use Nova\Pages\Page;
use Nova\Themes\Events;
use Nova\Themes\ThemesCollection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Themes\Models\Builders\ThemeBuilder;

class Theme extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $fillable = [
        'name', 'location', 'credits', 'active', 'default', 'layout_auth',
        'layout_public', 'layout_admin', 'layout_auth_settings',
        'layout_public_settings', 'layout_admin_settings', 'icon_set',
    ];

    protected $casts = [
        'active' => 'boolean',
        'default' => 'boolean',
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
     * Get the layout to use for the page.
     *
     * @param  Page  $page
     *
     * @return string
     */
    public function getLayoutForPage(Page $page)
    {
        return $this->getAttribute("layout_{$page->layout}");
    }

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name theme was {$eventName}";
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return \Nova\Themes\ThemesCollection
     */
    public function newCollection(array $models = [])
    {
        return new ThemesCollection($models);
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return ThemeBuilder
     */
    public function newEloquentBuilder($query): ThemeBuilder
    {
        return new ThemeBuilder($query);
    }
}
