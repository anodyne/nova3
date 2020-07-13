<?php

namespace Nova\Themes\Models;

use Nova\Pages\Page;
use Nova\Themes\Events;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Themes\Models\Builders\ThemeBuilder;
use Nova\Themes\Models\Collections\ThemesCollection;

class Theme extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $fillable = [
        'name', 'location', 'credits', 'active', 'preview', 'layout_auth',
        'layout_public', 'layout_admin', 'icon_set',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => Events\ThemeCreated::class,
        'deleted' => Events\ThemeDeleted::class,
        'updated' => Events\ThemeUpdated::class,
    ];

    public function getLayoutForPage(Page $page)
    {
        return $this->getAttribute("layout_{$page->layout}");
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name theme was {$eventName}";
    }

    public function newCollection(array $models = [])
    {
        return new ThemesCollection($models);
    }

    public function newEloquentBuilder($query): ThemeBuilder
    {
        return new ThemeBuilder($query);
    }
}
