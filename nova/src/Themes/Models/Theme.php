<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Pages\Page;
use Nova\Themes\Events;
use Nova\Themes\Models\Builders\ThemeBuilder;
use Nova\Themes\Models\Collections\ThemesCollection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Theme extends Model
{
    use HasFactory;
    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name theme was {$eventName}"
            );
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
