<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $version
 * @property string|null $credits
 * @property string|null $preview
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Bag\Bag $settings
 * @property \Bag\Bag|null $repository
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_update
 * @property-read bool $is_current_public_theme
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendingTheme whereVersion($value)
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
