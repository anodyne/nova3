<?php

declare(strict_types=1);

namespace Nova\Addons\Models;

use Database\Factories\AddonFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\BaseAddon;
use Nova\Addons\Data\AddonRepository;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Events\AddonCreated;
use Nova\Addons\Events\AddonDeleted;
use Nova\Addons\Events\AddonUpdated;
use Nova\Addons\Models\Builders\AddonBuilder;
use Nova\Foundation\Concerns\ChecksAddonVersion;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;
use UnexpectedValueException;

/**
 * @mixin IdeHelperAddon
 */
#[UseEloquentBuilder(AddonBuilder::class)]
class Addon extends Model
{
    use ChecksAddonVersion;

    /** @use HasFactory<AddonFactory> */
    use HasFactory;

    use HasPrefixedId;
    use LogsActivity;

    protected $casts = [
        'repository' => AddonRepository::class,
        'settings' => AddonSettings::class,
        'status' => BasicStatus::class,
        'type' => AddonType::class,
    ];

    protected $dispatchesEvents = [
        'created' => AddonCreated::class,
        'deleted' => AddonDeleted::class,
        'updated' => AddonUpdated::class,
    ];

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

    public function addonVersionCacheKey(): string
    {
        return 'nova-addons-latest-versions';
    }

    public function getAddonClass(): ?BaseAddon
    {
        if (! $this->has_addon_class) {
            return null;
        }

        $addonClass = 'Addons\\'.$this->location.'\\Addon';

        return new $addonClass;
    }

    /** @return Attribute<bool, never> */
    public function hasAddonClass(): Attribute
    {
        return Attribute::get(
            fn (): bool => class_exists('Addons\\'.$this->location.'\\Addon')
        );
    }

    public function runScript(string $name): void
    {
        $addonClass = $this->getAddonClass();

        $addonClass->runScript($name);
    }

    /** @return Collection<string, string> */
    public static function getInstallableAddons(): Collection
    {
        return collect(Storage::disk('addons')->directories())
            ->diff(static::pluck('location')->all())
            ->reject(fn ($path): bool => ! file_exists(addon_path($path.DIRECTORY_SEPARATOR.'addon.json')))
            ->flatMap(function (string $addon): array {
                $disk = Storage::disk('addons');

                $json = json_decode(
                    $disk->get($addon.DIRECTORY_SEPARATOR.'addon.json'),
                    flags: JSON_THROW_ON_ERROR,
                );

                if (! is_object($json) || ! isset($json->name) || ! is_string($json->name)) {
                    throw new UnexpectedValueException(
                        "Addon [{$addon}] has an invalid name."
                    );
                }

                return [$addon => $json->name];
            })
            ->sortBy(fn (string $value): string => $value);
    }

    public static function hasInstallableAddons(): bool
    {
        return static::getInstallableAddons()->count() > 0;
    }
}
