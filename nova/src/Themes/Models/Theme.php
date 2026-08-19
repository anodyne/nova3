<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

use Carbon\CarbonImmutable;
use Database\Factories\ThemeFactory;
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
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $version
 * @property string|null $credits
 * @property string|null $preview
 * @property BasicStatus $status
 * @property ThemeSettings $settings
 * @property AddonRepository|null $repository
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_update
 * @property-read bool $is_current_public_theme
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 *
 * @method static ThemeBuilder<static>|Theme active()
 * @method static ThemeFactory factory($count = null, $state = [])
 * @method static ThemeBuilder<static>|Theme inactive()
 * @method static ThemeBuilder<static>|Theme location($location)
 * @method static ThemeBuilder<static>|Theme newModelQuery()
 * @method static ThemeBuilder<static>|Theme newQuery()
 * @method static ThemeBuilder<static>|Theme query()
 * @method static ThemeBuilder<static>|Theme whereCreatedAt($value)
 * @method static ThemeBuilder<static>|Theme whereCredits($value)
 * @method static ThemeBuilder<static>|Theme whereId($value)
 * @method static ThemeBuilder<static>|Theme whereLocation($value)
 * @method static ThemeBuilder<static>|Theme whereName($value)
 * @method static ThemeBuilder<static>|Theme wherePreview($value)
 * @method static ThemeBuilder<static>|Theme whereRepository($value)
 * @method static ThemeBuilder<static>|Theme whereSettings($value)
 * @method static ThemeBuilder<static>|Theme whereStatus($value)
 * @method static ThemeBuilder<static>|Theme whereUpdatedAt($value)
 * @method static ThemeBuilder<static>|Theme whereVersion($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(ThemeBuilder::class)]
class Theme extends Model
{
    use ChecksAddonVersion;
    use HasFactory;
    use LogsActivity;

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

    protected $fillable = [
        'name', 'location', 'version', 'credits', 'status', 'preview', 'settings', 'repository',
    ];

    protected $table = 'themes';

    public function addonVersionCacheKey(): string
    {
        return 'nova-themes-latest-versions';
    }

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
