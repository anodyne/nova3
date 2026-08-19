<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Nova\Addons\Data\AddonRepository;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Themes\Data\ThemeSettings;
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
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_update
 * @property-read bool $is_current_public_theme
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 *
 * @method static Builder<static>|PendingTheme newModelQuery()
 * @method static Builder<static>|PendingTheme newQuery()
 * @method static Builder<static>|PendingTheme query()
 * @method static Builder<static>|PendingTheme whereCreatedAt($value)
 * @method static Builder<static>|PendingTheme whereCredits($value)
 * @method static Builder<static>|PendingTheme whereId($value)
 * @method static Builder<static>|PendingTheme whereLocation($value)
 * @method static Builder<static>|PendingTheme whereName($value)
 * @method static Builder<static>|PendingTheme wherePreview($value)
 * @method static Builder<static>|PendingTheme whereRepository($value)
 * @method static Builder<static>|PendingTheme whereSettings($value)
 * @method static Builder<static>|PendingTheme whereStatus($value)
 * @method static Builder<static>|PendingTheme whereUpdatedAt($value)
 * @method static Builder<static>|PendingTheme whereVersion($value)
 *
 * @mixin \Eloquent
 */
class PendingTheme extends Theme
{
    protected $table = 'themes';

    public function getKey(): string
    {
        return $this->location;
    }
}
