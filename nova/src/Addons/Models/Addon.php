<?php

declare(strict_types=1);

namespace Nova\Addons\Models;

use Carbon\CarbonImmutable;
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
use Spatie\Activitylog\Models\Activity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $location
 * @property string $version
 * @property string|null $credits
 * @property string|null $preview
 * @property AddonType $type
 * @property BasicStatus $status
 * @property AddonSettings|null $settings
 * @property AddonRepository|null $repository
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_addon_class
 * @property-read bool $has_update
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 *
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon active()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon extension()
 * @method static \Database\Factories\AddonFactory factory($count = null, $state = [])
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon genre()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon inactive()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon location(string $location)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon newModelQuery()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon newQuery()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon query()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon rankSet()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon searchFor($column, $search)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereCreatedAt($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereCredits($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereId($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereLocation($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereName($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon wherePrefixedId($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon wherePreview($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereRepository($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereSettings($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereStatus($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereType($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereUpdatedAt($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereVersion($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(AddonBuilder::class)]
class Addon extends Model
{
    use ChecksAddonVersion;
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

    public function hasAddonClass(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => class_exists('Addons\\'.$this->location.'\\Addon')
        );
    }

    public function runScript(string $name): void
    {
        $addonClass = $this->getAddonClass();

        $addonClass->runScript($name);
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
}
