<?php

declare(strict_types=1);

namespace Nova\Addons\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\BaseAddon;
use Nova\Addons\Data\AddonRepository;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonStatus;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Events;
use Nova\Addons\Models\Builders\AddonBuilder;
use Nova\Foundation\Concerns\ChecksAddonVersion;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class Addon extends Model
{
    use ChecksAddonVersion;
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity;

    protected $fillable = [
        'name', 'location', 'version', 'credits', 'status', 'preview', 'settings', 'type', 'repository',
    ];

    protected $casts = [
        'status' => AddonStatus::class,
        'settings' => AddonSettings::class,
        'type' => AddonType::class,
        'repository' => AddonRepository::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\AddonCreated::class,
        'deleted' => Events\AddonDeleted::class,
        'updated' => Events\AddonUpdated::class,
    ];

    public function getAddonClass(): ?BaseAddon
    {
        $addonClass = 'Addons\\'.$this->location.'\\Addon';

        if (! class_exists($addonClass)) {
            return null;
        }

        return new $addonClass;
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name add-on was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name add-on was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): AddonBuilder
    {
        return new AddonBuilder($query);
    }

    public static function getInstallableAddons(): Collection
    {
        return collect(Storage::disk('addons')->directories())
            ->diff(static::pluck('location')->all())
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

        if (method_exists($addonClass, $name)) {
            $addonClass->{$name}();
        }
    }

    public function addonVersionCacheKey(): string
    {
        return 'nova-addons-latest-versions';
    }
}
