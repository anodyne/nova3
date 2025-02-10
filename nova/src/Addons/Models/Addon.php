<?php

declare(strict_types=1);

namespace Nova\Addons\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\BaseAddon;
use Nova\Addons\Data\AddonRepository;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Events;
use Nova\Addons\Models\Builders\AddonBuilder;
use Nova\Foundation\Concerns\ChecksAddonVersion;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class Addon extends Model
{
    use ChecksAddonVersion;
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity;

    protected $fillable = [
        'credits',
        'location',
        'name',
        'preview',
        'repository',
        'settings',
        'status',
        'type',
        'version',
    ];

    protected $casts = [
        'repository' => AddonRepository::class,
        'settings' => AddonSettings::class,
        'status' => BasicStatus::class,
        'type' => AddonType::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\AddonCreated::class,
        'deleted' => Events\AddonDeleted::class,
        'updated' => Events\AddonUpdated::class,
    ];

    public function hasAddonClass(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => class_exists('Addons\\'.$this->location.'\\Addon')
        );
    }

    public function getAddonClass(): ?BaseAddon
    {
        if (! $this->has_addon_class) {
            return null;
        }

        $addonClass = 'Addons\\'.$this->location.'\\Addon';

        return new $addonClass;
    }

    public function newEloquentBuilder($query): AddonBuilder
    {
        return new AddonBuilder($query);
    }

    public static function getInstallableAddons(): Collection
    {
        return collect(Storage::disk('addons')->directories())
            ->diff(static::pluck('location')->all())
            ->reject(fn ($path) => ! file_exists(addon_path($path.DIRECTORY_SEPARATOR.'addon.json')))
            ->flatMap(function (string $addon): array {
                $disk = Storage::disk('addons');

                $json = json_decode($disk->get($addon.DIRECTORY_SEPARATOR.'addon.json'));

                return [$addon => $json->name];
            })
            ->sortBy(fn (string $value): string => $value);
    }

    public static function hasInstallableAddons(): bool
    {
        return static::getInstallableAddons()->count() > 0;
    }

    public function runScript(string $name): void
    {
        $addonClass = $this->getAddonClass();

        $addonClass->runScript($name);
    }

    public function addonVersionCacheKey(): string
    {
        return 'nova-addons-latest-versions';
    }
}
