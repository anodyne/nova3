<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Nova\Pages\Models\Page;
use Nova\Themes\Enums\ThemeStatus;
use Nova\Themes\Events;
use Nova\Themes\Models\Builders\ThemeBuilder;
use Nova\Themes\Models\Collections\ThemesCollection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Theme extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'themes';

    protected $fillable = [
        'name', 'location', 'credits', 'status', 'preview', 'layout_auth',
        'layout_public', 'layout_admin', 'icon_set',
    ];

    protected $casts = [
        'status' => ThemeStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\ThemeCreated::class,
        'deleted' => Events\ThemeDeleted::class,
        'updated' => Events\ThemeUpdated::class,
    ];

    public function getLayoutForPage(Page $page): string
    {
        return $this->getAttribute("layout_{$page->layout}");
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name theme was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name theme was {$eventName}"
            );
    }

    public function newCollection(array $models = []): ThemesCollection
    {
        return new ThemesCollection($models);
    }

    public function newEloquentBuilder($query): ThemeBuilder
    {
        return new ThemeBuilder($query);
    }

    public static function getInstallableThemes(): Collection
    {
        return collect(Storage::disk('themes')->directories())
            ->diff(static::pluck('location')->all());
    }

    public static function hasInstallableThemes(): bool
    {
        return static::getInstallableThemes()->count() > 0;
    }
}
