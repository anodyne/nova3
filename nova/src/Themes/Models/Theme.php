<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\Data\AddonRepository;
use Nova\Foundation\Concerns\ChecksAddonVersion;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Themes\BaseTheme;
use Nova\Themes\Data\ThemeSettings;
use Nova\Themes\Events\ThemeCreated;
use Nova\Themes\Events\ThemeDeleted;
use Nova\Themes\Events\ThemeUpdated;
use Nova\Themes\Models\Builders\ThemeBuilder;

#[UseEloquentBuilder(ThemeBuilder::class)]
class Theme extends Model
{
    use ChecksAddonVersion;
    use HasFactory;
    use LogsActivity;

    protected $table = 'themes';

    protected $fillable = [
        'name', 'location', 'version', 'credits', 'status', 'preview', 'settings', 'repository',
    ];

    protected $casts = [
        'status' => BasicStatus::class,
        'settings' => ThemeSettings::class,
        'repository' => AddonRepository::class,
    ];

    protected $dispatchesEvents = [
        'created' => ThemeCreated::class,
        'deleted' => ThemeDeleted::class,
        'updated' => ThemeUpdated::class,
    ];

    public function isCurrentPublicTheme(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => settings('appearance.theme') === $this->location
        );
    }

    public function themeClass(): BaseTheme
    {
        $themeClass = 'Themes\\'.$this->location.'\\Theme';

        return new $themeClass;
    }

    public function addonVersionCacheKey(): string
    {
        return 'nova-themes-latest-versions';
    }

    public static function getInstallableThemes(): Collection
    {
        $disk = Storage::disk('themes');

        return collect($disk->directories())
            ->diff(static::pluck('location')->all())
            ->filter(fn ($location) => $disk->exists("{$location}/theme.json"));
    }

    public static function hasInstallableThemes(): bool
    {
        return static::getInstallableThemes()->count() > 0;
    }
}
